<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class SessionCheck implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Verificar si el usuario está autenticado
        if (!session()->has('iduser')) {
            // Si no hay un usuario en sesión, redirige al logout
            return redirect()->to(site_url('/'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se necesita lógica después de procesar la solicitud
    }
}
