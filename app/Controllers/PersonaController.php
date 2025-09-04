<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Persona;

class PersonaController extends BaseController
{
    public function listar(): string
    {
        $persona = new Persona();

        $datos['personas'] = $persona->orderBy('idpersona', 'ASC')->findAll();

        // Header y Footer
        $datos['header'] = view('Layouts/header');
        $datos['footer'] = view('Layouts/footer');

        return view('personas/listar', $datos);
    }

    public function crear(): string
    {
        $datos['header'] = view('Layouts/header');
        $datos['footer'] = view('Layouts/footer');

        return view('personas/crear', $datos);
    }

    public function editar($id = null)
    {
        $persona = new Persona();

        $datos['header'] = view('Layouts/header');
        $datos['footer'] = view('Layouts/footer');
        $result = $persona->where('idpersona', $id)->first();

        if (!$result){ 
            return $this->response->redirect(base_url('personas/listar'));
        } else {
            $datos['persona'] = $result;
            return view('personas/editar', $datos);
        }
    }

    // Insertar registro
    public function guardar()
    {
    $persona = new Persona();

    $numerodoc = $this->request->getVar('numerodoc');

    // 🔒 Verificar si ya existe ese DNI
    $existe = $persona->where('numerodoc', $numerodoc)->first();

    if ($existe) {
        // Redirige de vuelta con advertencia y mantiene los datos
        return redirect()->back()->with('error', '⚠️ El número de documento (DNI) ya está registrado.')->withInput();
    }

    $registro = [
        'apepaterno'       => $this->request->getVar('apepaterno'),
        'apematerno'       => $this->request->getVar('apematerno'),
        'nombres'          => $this->request->getVar('nombres'),
        'tipodoc'          => $this->request->getVar('tipodoc'),
        'numerodoc'        => $numerodoc,
        'direccion'        => $this->request->getVar('direccion'),
        'telefono'         => $this->request->getVar('telefono'),
        'email'            => $this->request->getVar('email'),
        'fecha_nacimiento' => $this->request->getVar('fecha_nacimiento'),
        'sexo'             => $this->request->getVar('sexo')
    ];

    // Manejo de imagen
    if ($imagen = $this->request->getFile('imagenperfil')) {
        if ($imagen->isValid() && !$imagen->hasMoved()) {
            $nuevoNombre = $imagen->getRandomName();
            $imagen->move('../public/uploads/', $nuevoNombre);
            $registro['imagenperfil'] = $nuevoNombre;
        }
    }

    $persona->insert($registro);
    return $this->response->redirect(base_url('personas/listar'));
    }


    public function borrar($id = null)
    {
        $persona = new Persona();

        // Borrar imagen asociada
        $datosPersona = $persona->where('idpersona', $id)->first();
        if ($datosPersona && !empty($datosPersona['imagenperfil'])){
            $rutaImagen = '../public/uploads/' . $datosPersona['imagenperfil'];
            if (file_exists($rutaImagen)){ unlink($rutaImagen); }
        }

        // Borrar registro
        $persona->where('idpersona', $id)->delete($id);

        return $this->response->redirect(base_url('personas/listar'));
    }

    public function actualizar()
    {
        $persona = new Persona();

        $id = $this->request->getVar('idpersona');

        $datos = [
            'apepaterno'       => $this->request->getVar('apepaterno'),
            'apematerno'       => $this->request->getVar('apematerno'),
            'nombres'          => $this->request->getVar('nombres'),
            'tipodoc'          => $this->request->getVar('tipodoc'),
            'numerodoc'        => $this->request->getVar('numerodoc'),
            'direccion'        => $this->request->getVar('direccion'),
            'telefono'         => $this->request->getVar('telefono'),
            'email'            => $this->request->getVar('email'),
            'fecha_nacimiento' => $this->request->getVar('fecha_nacimiento'),
            'sexo'             => $this->request->getVar('sexo')
        ];

        $persona->update($id, $datos);

        // Validación de imagen nueva
        $validacion = $this->validate([
            'imagenperfil' => [
                'uploaded[imagenperfil]',
                'mime_in[imagenperfil,image/png,image/jpg,image/jpeg]',
                'max_size[imagenperfil,2048]'
            ]
        ]);

        if ($validacion){
            if ($imagen = $this->request->getFile('imagenperfil')){
                $datosPersona = $persona->where('idpersona', $id)->first();
                if ($datosPersona && !empty($datosPersona['imagenperfil'])){
                    $rutaImagen = '../public/uploads/' . $datosPersona['imagenperfil'];
                    if (file_exists($rutaImagen)) { unlink($rutaImagen); }
                }

                $nuevoNombre = $imagen->getRandomName();
                $imagen->move('../public/uploads/', $nuevoNombre);

                $persona->update($id, ['imagenperfil' => $nuevoNombre]);
            }
        }

        return $this->response->redirect(base_url('personas/listar'));
    }
}
