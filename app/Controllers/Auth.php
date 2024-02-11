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
        $user = $model->getUserData($username);

        if ($user && $model->verifyPassword($password, $user->password)) {
            // Verificar si la cuenta está suspendida
            if ($user->activo !== null) {
                $data['error_message'] = 'Su cuenta está suspendida. Por favor, contacte al administrador.';
                return view('auth/login', $data);
            }

            $session = session();
            $session->set([
                'role' => $model->getRoleName($user->id_rol),
                'email' => $user->email,
                'idrol' => $user->id_rol,
                'username' => $user->nombre,
                'iduser' => $user->user_id,
            ]);

            if ($user->id_rol == 1) { 
                return redirect()->to('admin/dashboard');
            } elseif ($user->id_rol == 2) { 
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
