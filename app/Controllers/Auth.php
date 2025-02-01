<?php

namespace App\Controllers;

use App\Models\AuthModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    protected $maxAttempts = 5;
    protected $lockoutTime = 300; // 5 minutes

    public function submit_login()
    {
        $session = session();
        $model = new AuthModel();
        $logger = \Config\Services::logger();
        $recaptchaSecret = 'YOUR_SECRET_KEY';
        $recaptchaVerifyUrl = 'https://www.google.com/recaptcha/api/siteverify';

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $recaptchaResponse = $this->request->getPost('g-recaptcha-response');

     /*    // Verify reCAPTCHA
        $response = file_get_contents($recaptchaVerifyUrl . '?secret=' . $recaptchaSecret . '&response=' . $recaptchaResponse);
        $responseKeys = json_decode($response, true);

         if (intval($responseKeys["success"]) !== 1) {
            $data['error_message'] = 'Por favor complete the reCAPTCHA.';
            return view('auth/login', $data);
        }  */

        // Get attempts from session
        $attempts = $session->get('login_attempts') ?? 0;
        $lastAttemptTime = $session->get('last_attempt_time') ?? time();

        // Check if user is locked out
        if ($attempts >= $this->maxAttempts && (time() - $lastAttemptTime) < $this->lockoutTime) {
            $logger->error("IP: {$_SERVER['REMOTE_ADDR']}");
            $data['error_message'] = 'Haz hecho muchos intentos, intenta mas tarde!';
            return view('auth/login', $data);
        }

        $user = $model->getUserData($username);

        if ($user && $model->verifyPassword($password, $user->password)) {
            if ($user->activo !== null) {
                $data['error_message'] = 'Su cuenta está suspendida. Por favor, contacte al administrador.';
                return view('auth/login', $data);
            }

            // Reset attempts on successful login
            $session->set('login_attempts', 0);

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
                $session_data = " ";  
            }
            $session->set($session_data);
            $session = session();
        $idUsuario = $session->get('iduser');

        if (!$idUsuario) {
            return redirect()->to('Auth/login'); // Redirige al login si no hay sesión
        }

            if ($user->id_rol == 1) { 
                return redirect()->to('admin/dashboard');
            } elseif ($user->id_rol == 2 or $user->id_rol == 3 ) { 
                return redirect()->to('teacher/dashboard');
            } else {
                return redirect()->to('/');
            }
        } else {
            // Increment attempts on failed login
            $session->set('login_attempts', $attempts + 1);
            $session->set('last_attempt_time', time());
            $logger->warning("Failed login attempt for user: $username from IP: {$_SERVER['REMOTE_ADDR']}");
            $data['error_message'] = 'Credenciales incorrectas';
            return view('Auth/login', $data);
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
