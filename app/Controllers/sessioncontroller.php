<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class CheckSession extends Controller
{
    public function __construct()
    {
        // Carga los servicios necesarios
        helper(['url', 'cookie']);
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        // Verificar si existe una sesión activa
        $authenticated = $this->session->has('iduser');

        // Verificar el tiempo de sesión (ejemplo: 30 minutos)
        $sessionTimeout = 1800; // 30 minutos en segundos
        $lastActivity = $this->session->get('last_activity');

        if ($authenticated && (time() - $lastActivity > $sessionTimeout)) {
            // La sesión ha expirado
            $this->session->destroy(); // Destruir la sesión expirada
            $message = 'Su sesión ha expirado. Por favor, inicie sesión nuevamente.';
            return $this->response->setJSON(['authenticated' => false, 'error' => $message]);
        }

        // Actualizar la actividad de la sesión
        $this->session->set('last_activity', time());

        return $this->response->setJSON(['authenticated' => $authenticated]);
    }
}