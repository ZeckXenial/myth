<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CrudUsuarioModel;

class CrudUsuariosController extends Controller
{
    public function index()
    {
        $model = new CrudUsuarioModel();
        $data['users'] = $model->obtenerUsuariosConRoles();
        return view('components/crud_usuarios', $data);
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
                    $model = new CrudUsuarioModel();
                    $data = [
                        'nombre' => $this->request->getPost('nombre'),
                        'email' => $this->request->getPost('email'),
                        'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                        'id_rol' => $this->request->getPost('id_rol'),
                    ];
    
                    $model->agregarUsuario($data);
    
                    return redirect()->to(site_url('crud_usuarios'))->with('success', 'Usuario agregado exitosamente');
                } catch (\Exception $e) {
                    return redirect()->to(site_url('crud_usuarios'))->withInput()->with('error', 'Error al agregar usuario: ' . $e->getMessage());
                }
            } else {
                return redirect()->to(site_url('crud_usuarios'))->withInput()->with('errors', $validation->getErrors());
            }
        }
    
        return redirect()->to(site_url('components/crud_usuarios'));
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
            $model = new CrudUsuarioModel();
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

            return redirect()->to(site_url('crud_usuarios'))->with('success', 'Usuario editado exitosamente');
        } else {
            return redirect()->to(site_url('crud_usuarios'))->withInput()->with('errors', $validation->getErrors());
        }
    }

    return redirect()->to(site_url('crud_usuarios'));
}

    public function eliminar($id)
    {
        $model = new CrudUsuarioModel();
        $model->eliminarUsuario($id);

        return redirect()->to(site_url('crud_usuarios'))->with('success', 'Usuario eliminado exitosamente');
    }
}
