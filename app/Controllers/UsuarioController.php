<?php
namespace App\Controllers;

use App\Models\Usuario;

class UsuarioController extends BaseController
{
    public function listar()
    {
        $usuarioModel = new Usuario();
        $data['usuarios'] = $usuarioModel->getUsuariosConPersona();

        // Header y Footer
        $data['header'] = view('layouts/header');
        $data['footer'] = view('layouts/footer');

        return view('usuarios/listar', $data);
    }

    public function crear()
    {
        $personaModel = new \App\Models\Persona();
        $data['personas'] = $personaModel->orderBy('idpersona', 'ASC')->findAll();

        // Header y Footer
        $data['header'] = view('layouts/header');
        $data['footer'] = view('layouts/footer');

        return view('usuarios/crear', $data);
    }

    public function guardar()
    {
        $usuarioModel = new Usuario();

        $nomuser = $this->request->getVar('nomuser');
        $passuser = $this->request->getVar('passuser');
        $estado = $this->request->getVar('estado');
        $idpersona = $this->request->getVar('idpersona');

        // 🔒 Verificar si ya existe ese nombre de usuario
        $existe = $usuarioModel->where('nomuser', $nomuser)->first();

        if ($existe) {
            // Redirige de vuelta con advertencia y mantiene los datos
            return redirect()->back()->with('error', '⚠️ El nombre de usuario ya está registrado.')->withInput();
        }

        // Hashear la contraseña antes de guardarla
        $hashedPassword = password_hash($passuser, PASSWORD_BCRYPT);

        $datos = [
            'nomuser' => $nomuser,
            'passuser' => $hashedPassword,
            'estado' => $estado,
            'idpersona' => $idpersona
        ];

        $usuarioModel->insert($datos);
        return redirect()->to(base_url('usuarios/listar'))->with('success', '✅ Usuario creado exitosamente.');
    }

    public function editar($id = null)
    {
        $usuarioModel = new Usuario();
        $personaModel = new \App\Models\Persona();

        $data['usuario'] = $usuarioModel->where('idusuario', $id)->first();
        $data['personas'] = $personaModel->orderBy('idpersona', 'ASC')->findAll();

        if (!$data['usuario']) {
            return redirect()->to(base_url('usuarios/listar'))->with('error', '⚠️ Usuario no encontrado.');
        }

        // Header y Footer
        $data['header'] = view('layouts/header');
        $data['footer'] = view('layouts/footer');

        return view('usuarios/editar', $data);
    }

    
    public function actualizar($idusuario)
{
    $usuarioModel = new \App\Models\Usuario();

    $nomuser   = $this->request->getPost('nomuser');
    $passuser  = $this->request->getPost('passuser');
    $estado    = $this->request->getPost('estado');
    $idpersona = $this->request->getPost('idpersona');

    // Verificar si el usuario existe
    $usuarioExistente = $usuarioModel->find($idusuario);
    if (!$usuarioExistente) {
        return redirect()->to(base_url('usuarios/listar'))
                         ->with('error', '⚠️ Usuario no encontrado.');
    }

    // Verificar si el nombre de usuario ya existe en otro usuario
    $existe = $usuarioModel->where('nomuser', $nomuser)
                           ->where('idusuario !=', $idusuario)
                           ->first();
    if ($existe) {
        return redirect()->back()
                         ->with('error', '⚠️ El nombre de usuario ya está registrado.')
                         ->withInput();
    }

    // Datos para actualizar
    $datos = [
        'nomuser'   => $nomuser,
        'estado'    => $estado,
        'idpersona' => $idpersona
    ];

    // Solo actualizar contraseña si fue ingresada
    if (!empty($passuser)) {
        $datos['passuser'] = password_hash($passuser, PASSWORD_BCRYPT);
    }

    $usuarioModel->update($idusuario, $datos);

    return redirect()->to(base_url('usuarios/listar'))
                     ->with('success', '✅ Usuario actualizado exitosamente.');
    }
    public function borrar($id = null)
    {
        $usuarioModel = new Usuario();

        // Verificar si el usuario existe
        $usuarioExistente = $usuarioModel->where('idusuario', $id)->first();
        if (!$usuarioExistente) {
            return redirect()->to(base_url('usuarios/listar'))->with('error', '⚠️ Usuario no encontrado.');
        }

        $usuarioModel->delete($id);
        return redirect()->to(base_url('usuarios/listar'))->with('success', '✅ Usuario eliminado exitosamente.');
    }
}

