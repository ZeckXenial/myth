<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CrudUsuarioModel;

class CrudUsuariosController extends Controller
{
    public function index()
    {
        $model = new CrudUsuarioModel();
        $data['users'] = $model->obtenerUsuarios();
        return view('components/crud_usuarios', $data);
    }

    public function agregar()
    {
        $model = new CrudUsuarioModel();

        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();

            $rules = [
                'rut' => 'required|alpha_numeric',
                'nombre' => 'required|min_length[3]|max_length[255]',
                'email' => 'required|valid_email',
                'rol' => 'required',
            ];

            if ($this->validate($rules)) {
                $datos = [
                    'rut' => $this->request->getPost('rut'),
                    'nombre' => $this->request->getPost('nombre'),
                    'email' => $this->request->getPost('email'),
                    'rol' => $this->request->getPost('rol'),
                ];

                $model->agregarUsuario($datos);

                return redirect()->to(site_url('crud_usuarios'))->with('success', 'Usuario agregado exitosamente');
            } else {
                return redirect()->to(site_url('crud_usuarios'))->withInput()->with('errors', $validation->getErrors());
            }
        }

        return redirect()->to(site_url('crud_usuarios'));
    }

    public function editar($rut)
    {
        $model = new CrudUsuarioModel();

        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();

            $rules = [
                'nombre_edit' => 'required|min_length[3]|max_length[255]',
                'email_edit' => 'required|valid_email',
                'rol_edit' => 'required',
            ];

            if ($this->validate($rules)) {
                $datos = [
                    'nombre' => $this->request->getPost('nombre_edit'),
                    'email' => $this->request->getPost('email_edit'),
                    'rol' => $this->request->getPost('rol_edit'),
                ];

                $model->editarUsuario($rut, $datos);

                return redirect()->to(site_url('crud_usuarios'))->with('success', 'Usuario editado exitosamente');
            } else {
                return redirect()->to(site_url('crud_usuarios'))->withInput()->with('errors', $validation->getErrors());
            }
        }

        return redirect()->to(site_url('crud_usuarios'));
    }

    public function eliminar($rut)
    {
        $model = new CrudUsuarioModel();
        $model->eliminarUsuario($rut);

        return redirect()->to(site_url('crud_usuarios'))->with('success', 'Usuario eliminado exitosamente');
    }
}
