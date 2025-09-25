<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Persona;

class PersonaController extends BaseController
{
    public function listar(): string
    {
        $persona = new Persona();
        $pager = \Config\Services::pager();

        // Número de registros por página
        $perPage = 10; 

        // Total de registros en la base de datos
        $totalRows = $persona->countAll();

        // Obtener la página actual de la URL
        $currentPage = $this->request->getVar('page') ?? 1;

        // Obtener los datos de personas con paginación
        $datos['personas'] = $persona->orderBy('idpersona', 'ASC')
                                      ->paginate($perPage, 'default', $currentPage);

        // Configurar los enlaces de paginación
        $datos['pagination'] = $pager->links();

        // Pasar el total de registros a la vista
        $datos['total_personas'] = $totalRows;

        // Header y Footer
        $datos['header'] = view('Layouts/header');
        $datos['footer'] = view('Layouts/footer');

        // Cargar la vista con los datos
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

        $result = $persona->find($id);

        if (!$result) {
            return $this->response->redirect(base_url('personas/listar'));
        } else {
            $datos['persona'] = $result;
            $datos['header'] = view('Layouts/header');
            $datos['footer'] = view('Layouts/footer');
            return view('personas/editar', $datos);
        }
    }

    public function guardar()
    {
        $persona = new Persona();

        $numerodoc = $this->request->getVar('numerodoc');
        $existe = $persona->where('numerodoc', $numerodoc)->first();

        if ($existe) {
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
        $personaData = $persona->find($id);
        if ($personaData && !empty($personaData['imagenperfil'])) {
            $rutaImagen = '../public/uploads/' . $personaData['imagenperfil'];
            if (file_exists($rutaImagen)) {
                unlink($rutaImagen);
            }
        }

        $persona->delete($id);

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

        if ($validacion) {
            if ($imagen = $this->request->getFile('imagenperfil')) {
                // Eliminar imagen antigua si existe
                $personaData = $persona->find($id);
                if ($personaData && !empty($personaData['imagenperfil'])) {
                    $rutaImagen = '../public/uploads/' . $personaData['imagenperfil'];
                    if (file_exists($rutaImagen)) {
                        unlink($rutaImagen);
                    }
                }

                $nuevoNombre = $imagen->getRandomName();
                $imagen->move('../public/uploads/', $nuevoNombre);

                $persona->update($id, ['imagenperfil' => $nuevoNombre]);
            }
        }

        return $this->response->redirect(base_url('personas/listar'));
    }
}
