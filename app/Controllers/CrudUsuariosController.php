<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\crudusuariomodel;

class CrudUsuariosController extends Controller
{
    public function index()
    {
        $model = new crudusuariomodel();
        $data['users'] = $model->obtenerUsuariosConRoles();
        return view('Components/crud_usuarios', $data);
    }

    public function agregar()
    {
        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();
    
            $rules = [
                'nombre' => 'required|min_length[3]|max_length[50]',
                'email' => 'required|valid_email',
                'password' => 'required|min_length[6]',
                'id_rol' => 'required',
            ];
    
            if ($this->validate($rules)) {
                try {
                    $model = new crudusuariomodel();
                    $data = [
                        'nombre' => $this->request->getPost('nombre'),
                        'especialidad' => $this->request->getPost('especialidad'),
                        'email' => $this->request->getPost('email'),
                        'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                        'id_rol' => $this->request->getPost('id_rol'),
                    ];
    
                    $model->agregarUsuario($data);
    
                    return redirect()->to(site_url('usuarios'))->with('success', 'Usuario agregado exitosamente');
                } catch (\Exception $e) {
                    return redirect()->to(site_url('usuarios'))->withInput()->with('error', 'Error al agregar usuario: ' . $e->getMessage());
                }
            } else {
                return redirect()->to(site_url('usuarios'))->withInput()->with('errors', $validation->getErrors());
            }
        }
    
        return redirect()->to(site_url('usuarios'));
    }
    
    public function miInformacion()
    {
        $model = new crudusuariomodel();
        $session = session();
        $userId = $session->get('iduser');
        $data['usuario'] = $model->obtenerUsuarioPorId($userId);
        return view('Components/mi_informacion', $data);
    }

    public function actualizarInformacion()
    {
        if ($this->request->getMethod() === 'post') {
            log_message('debug', 'M¨¦todo POST recibido.');
            $model = new crudusuariomodel();
            $session = session();
            $userId = $session->get('iduser');
            log_message('debug', 'User ID: ' . $userId);
    
            $validation = \Config\Services::validation();
    
            $rules = [
                'nombre' => 'required|min_length[3]|max_length[50]',
                'especialidad' => 'max_length[50]',
            ];
    
            if (!empty($this->request->getPost('password'))) {
                $rules['password'] = 'required|min_length[6]';
            }
    
            if ($this->validate($rules)) {
                log_message('debug', 'Validaci¨®n exitosa.');
                $data = [
                    'nombre' => $this->request->getPost('nombre'),
                    'especialidad' => $this->request->getPost('especialidad'),
                ];
    
                if (!empty($this->request->getPost('password'))) {
                    $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
                }
    
                $model->actualizarUsuario($userId, $data);
                log_message('debug', 'Usuario actualizado.');
                log_message('debug', 'Redirigiendo a: ' . site_url('usuario/mi_informacion'));
                return redirect()->to(site_url('usuario/mi_informacion'))->with('success', 'Informaci¨®n actualizada exitosamente');
            } else {
                log_message('debug', 'Errores de validaci¨®n: ' . json_encode($validation->getErrors()));
                return redirect()->to(site_url('usuario/mi_informacion'))->withInput()->with('errors', $validation->getErrors());
            }
        }
    }  

    public function editar($id)
    {
        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();

            $rules = [
                'nombre_edit' => 'required|min_length[3]|max_length[50]',
                'id_rol' => 'required'
            ];

            if (!empty($this->request->getPost('password_edit'))) {
                $rules['password_edit'] = 'required|min_length[6]';
            }

            if (!empty($this->request->getPost('email_edit'))) {
                $rules['email_edit'] = 'required|valid_email';
            }

            if ($this->validate($rules)) {
                $model = new crudusuariomodel();
                $data = [
                    'nombre' => $this->request->getPost('nombre_edit'),
                    'email' => $this->request->getPost('email_edit'),
                    'id_rol' => $this->request->getPost('id_rol'),
                    'especialidad' => $this->request->getPost('especialidad')
                ];

                if (!empty($this->request->getPost('password_edit'))) {
                    $data['password'] = password_hash($this->request->getPost('password_edit'), PASSWORD_DEFAULT);
                }

                $model->editarUsuario($id, $data);

                return redirect()->to(site_url('usuarios'))->with('success', 'Usuario editado exitosamente');
            } else {
                return redirect()->to(site_url('usuarios'))->withInput()->with('errors', $validation->getErrors());
            }
        }

        return redirect()->to(site_url('usuarios'));
    }

    public function eliminar($id)
    {
        $model = new crudusuariomodel();
        $model->eliminarUsuario($id);

        return redirect()->to(site_url('usuarios'))->with('success', 'Usuario eliminado exitosamente');
    }
}
