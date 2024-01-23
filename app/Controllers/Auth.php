<?php

namespace App\Controllers;

use App\Models\AuthModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function submit_login()
    {
        $model = new AuthModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userData = $model->getUserData($username, $password);

        if ($userData) {
            // Almacenar todos los datos en la sesión
            session()->set([
                'role' => $userData->role,
                'username' => $userData->full_name,
                'cod_est' => $userData->cod_est,
                'establecimiento' => $userData->nombre_est,
                'iduser' => $userData->iduser
            ]);

            // Redireccionar según el rol
            if ($userData->role == 'directive') {
                return redirect()->to('admin/dashboard');
            } elseif ($userData->role == 'teacher') {
                return redirect()->to('teacher/dashboard');
            } else {
                return redirect()->to('/');
            }
        } else {
            $data['error_message'] = 'Credenciales incorrectas';
            return view('auth/login', $data);
        }
    }

    public function logout()
    {
        // Destruir la sesión
        session()->destroy();

        // Redireccionar al inicio
        return redirect()->to('/');
    }
}
