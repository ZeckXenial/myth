<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $uri = $request->uri;

        // Permitir acceso a la página de inicio y al login
        if ($uri->getPath() === '/' || $uri->getPath() === 'login') {
            return $request;
        }

        // Verificar si el usuario está autenticado
        if (!session()->get('role')) {
            // Si no está autenticado, redirigir al login
            return redirect()->to('/');
        }

        // Continuar con la ejecución normal
        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Lógica después de la ejecución del controlador
    }
}
