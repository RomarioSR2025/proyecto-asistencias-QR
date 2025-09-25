<?php
namespace App\Controllers;

use App\Models\Usuario;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth/login');
    }

    public function loginPost()
    {
        $session = \Config\Services::session();
        $model = new Usuario();

        $username = $this->request->getPost('nomuser');
        $password = $this->request->getPost('passuser');

        $usuario = $model->where('nomuser', $username)->first();

        if ($usuario && $usuario['estado'] === 'Activo') {
            // ⚠️ Contraseña encriptada con bcrypt
            if (password_verify($password, $usuario['passuser'])) {

                // Obtener roles del usuario desde la base
                $roles = $model->getRoles($usuario['idusuario']); // Devuelve array ['Administrador','Docente',...]

                $session->set([
                    'usuario_id'     => $usuario['idusuario'],
                    'usuario_nombre' => $usuario['nomuser'],
                    'usuario_roles'  => $roles,
                    'isLoggedIn'     => true
                ]);

                return redirect()->to(base_url('usuarios/listar'));
            }
        }

        return redirect()->back()->with('error', 'Usuario o contraseña incorrectos');
    }

    public function logout()
    {
        $session = \Config\Services::session();
        $session->destroy();
        return redirect()->to(base_url('login'));
    }
}
