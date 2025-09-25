<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = \Config\Services::session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $usuarioRoles = $session->get('usuario_roles') ?? [];

        if ($arguments && count(array_intersect($usuarioRoles, $arguments)) === 0) {
            return redirect()->to(base_url(''))->with('error', '⚠️ No tienes permisos para acceder a esta página.');
        }
    }

    public function after(RequestInterface $request, $response, $arguments = null)
    {
        // Nada después
    }
}
