<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Usuario;
use App\Models\Persona;
use App\Models\Rol;
use App\Models\UsuarioRol;

class UsuarioController extends BaseController
{
    public function listar()
    {
        $usuarioModel = new Usuario();
        $data['usuarios'] = $usuarioModel->getUsuariosConPersona();

        $data['header'] = view('layouts/header');
        $data['footer'] = view('layouts/footer');

        return view('usuarios/listar', $data);
    }

    public function crear()
    {
        $personaModel = new Persona();
        $rolModel = new Rol();

        $data['personas'] = $personaModel->findAll();
        $data['roles']    = $rolModel->findAll();

        $data['header'] = view('layouts/header');
        $data['footer'] = view('layouts/footer');

        return view('usuarios/crear', $data);
    }

    public function guardar()
    {
        $usuarioModel = new Usuario();
        $usuarioRolModel = new UsuarioRol();

        $nomuser   = $this->request->getPost('nomuser');
        $passuser  = $this->request->getPost('passuser');
        $estado    = $this->request->getPost('estado');
        $idpersona = $this->request->getPost('idpersona');
        $idrol     = $this->request->getPost('idrol');

        if ($usuarioModel->where('nomuser', $nomuser)->first()) {
            return redirect()->back()->with('error', '⚠️ El usuario ya existe.')->withInput();
        }

        $usuarioModel->insert([
            'nomuser'   => $nomuser,
            'passuser'  => password_hash($passuser, PASSWORD_BCRYPT),
            'estado'    => $estado,
            'idpersona' => $idpersona
        ]);

        $idusuario = $usuarioModel->getInsertID();

        if (!empty($idrol)) {
            $usuarioRolModel->insert([
                'idusuario' => $idusuario,
                'idrol'     => $idrol
            ]);
        }

        return redirect()->to(base_url('usuarios/listar'))->with('success', '✅ Usuario creado correctamente.');
    }

    public function editar($idusuario = null)
    {
        $usuarioModel = new Usuario();
        $personaModel = new Persona();
        $rolModel     = new Rol();
        $usuarioRolModel = new UsuarioRol();

        $data['usuario']  = $usuarioModel->find($idusuario);
        $data['personas'] = $personaModel->findAll();
        $data['roles']    = $rolModel->findAll();
        $data['rolActual'] = $usuarioRolModel->where('idusuario', $idusuario)->first();

        if (!$data['usuario']) {
            return redirect()->to(base_url('usuarios/listar'))->with('error', '⚠️ Usuario no encontrado.');
        }

        $data['header'] = view('layouts/header');
        $data['footer'] = view('layouts/footer');

        return view('usuarios/editar', $data);
    }

    public function actualizar($idusuario)
    {
        $usuarioModel = new Usuario();
        $usuarioRolModel = new UsuarioRol();

        $nomuser   = $this->request->getPost('nomuser');
        $passuser  = $this->request->getPost('passuser');
        $estado    = $this->request->getPost('estado');
        $idpersona = $this->request->getPost('idpersona');
        $idrol     = $this->request->getPost('idrol');

        $usuario = $usuarioModel->find($idusuario);
        if (!$usuario) {
            return redirect()->to(base_url('usuarios/listar'))->with('error', '⚠️ Usuario no encontrado.');
        }

        $datos = [
            'nomuser'   => $nomuser,
            'estado'    => $estado,
            'idpersona' => $idpersona
        ];

        if (!empty($passuser)) {
            $datos['passuser'] = password_hash($passuser, PASSWORD_BCRYPT);
        }

        $usuarioModel->update($idusuario, $datos);

        $usuarioRolModel->where('idusuario', $idusuario)->delete();
        if (!empty($idrol)) {
            $usuarioRolModel->insert([
                'idusuario' => $idusuario,
                'idrol'     => $idrol
            ]);
        }

        return redirect()->to(base_url('usuarios/listar'))->with('success', '✅ Usuario actualizado correctamente.');
    }

    public function borrar($idusuario = null)
    {
        $usuarioModel = new Usuario();
        $usuarioRolModel = new UsuarioRol();

        if (!$usuarioModel->find($idusuario)) {
            return redirect()->to(base_url('usuarios/listar'))->with('error', '⚠️ Usuario no encontrado.');
        }

        $usuarioRolModel->where('idusuario', $idusuario)->delete();
        $usuarioModel->delete($idusuario);

        return redirect()->to(base_url('usuarios/listar'))->with('success', '✅ Usuario eliminado correctamente.');
    }
}
