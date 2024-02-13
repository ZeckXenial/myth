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
        $model = new CrudUsuarioModel();

        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();

            $rules = [
                'nombre' => 'required|min_length[3]|max_length[50]',
                'email' => 'required|valid_email',
                'password' => 'required|min_length[6]',
                'id_rol' => 'required',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'nombre' => $this->request->getPost('nombre'),
                    'email' => $this->request->getPost('email'),
                    'especialidad' => $this->request->getPost('especialidad'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                    'id_rol' => $this->request->getPost('id_rol'),
                ];

                $model->agregarUsuario($data);

                return redirect()->to(site_url('crud_usuarios'))->with('success', 'Usuario agregado exitosamente');
            } else {
                return redirect()->to(site_url('crud_usuarios'))->withInput()->with('errors', $validation->getErrors());
            }
        }

        return redirect()->to(site_url('components/crud_usuarios'));
    }

    public function editar($id)
    {
        $model = new CrudUsuarioModel();
    
        if ($this->request->getMethod() === 'post') {
            $data = [
                'nombre' => $this->request->getPost('nombre'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'id_rol' => $this->request->getPost('id_rol'),
            ];
    
            $model->editarUsuario($id, $data);
    
            return redirect()->to(site_url('crud_usuarios'))->with('success', 'Usuario editado exitosamente');
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
