<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $session = session();
        $userId = $session->get('iduser');

        $model = new AuthModel();
        $userData = $model->getUserDataById($userId);

        if ($userData) {
            $data['user'] = [
                'nombre' => $userData->nombre,
                'email' => $userData->email,
                'rol' => $userData->id_rol // Puedes cambiar esto para mostrar el nombre del rol si lo deseas
            ];
            return view('dashboard/index', $data);
        } else {
            // Manejar el caso de que no se encuentren los datos del usuario
            // Por ejemplo, redirigiendo a la página de inicio de sesión
            return redirect()->to('login');
        }
    }
}
