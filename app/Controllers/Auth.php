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
            $courseOrSubject = $model->getCourseOrSubjectId($user->user_id);

            if ($courseOrSubject) {
                $session_data['type'] = $courseOrSubject['type'];
                $session_data['id_course_or_subject'] = $courseOrSubject['id'];
            }
            if ($courseOrSubject != True or $courseOrSubject < '0'){
                $session_data = " ";  //Si no tiene asignado curso
            }
            $session->set($session_data);
            if ($user->id_rol == 1) { 
                return redirect()->to('admin/dashboard');
            } elseif ($user->id_rol == 2 or $user->id_rol == 3 ) { 
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
        session()->destroy();

      
        return redirect()->to('/');
    }
}
