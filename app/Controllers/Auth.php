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
        $idRol = $model->submit_login($username, $password);

        if ($idRol) {
            session()->set([
                'role' => $idRol,
                'username' => $model->getFullName($username),
                'iduser' => $model->getIdUser($username)
            ]);

            if ($idRol == 2) { 
                return redirect()->to('admin/dashboard');
            } elseif ($idRol == 1) { 
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
