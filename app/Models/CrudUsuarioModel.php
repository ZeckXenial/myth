<?php

namespace App\Models;

use CodeIgniter\Model;

class CrudUsuarioModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'rut';
    protected $allowedFields = ['rut', 'full_name', 'email', 'role'];

    public function obtenerUsuarios()
    {
        return $this->findAll();
    }

    public function obtenerUsuarioPorRut($rut)
    {
        return $this->find($rut);
    }

    public function agregarUsuario($datos)
    {
        return $this->insert($datos);
    }

    public function editarUsuario($rut, $datos)
    {
        return $this->update($rut, $datos);
    }

    public function eliminarUsuario($rut)
    {
        return $this->delete($rut);
    }
}
