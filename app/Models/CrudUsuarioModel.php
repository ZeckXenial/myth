<?php

namespace App\Models;

use CodeIgniter\Model;

class CrudUsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'user_id';
    protected $allowedFields = ['nombre', 'email', 'password', 'id_rol', 'especialidad','activo'];

    public function obtenerUsuariosConRoles()
    {
        return $this->db->table('usuarios')
            ->select('usuarios.*, roles.glosa as nombre_rol')
            ->join('roles', 'roles.id_rol = usuarios.id_rol')
            ->where('activo', null)// Filtrar usuarios activos
            ->get()
            ->getResultArray();
    }

    public function obtenerUsuarioPorId($id)
    {
        return $this->find($id);
    }

    public function agregarUsuario($datos)
    {
        return $this->insert($datos);
    }

    public function editarUsuario($id, $datos)
    {
        return $this->update($id, $datos);
    }

    public function eliminarUsuario($id)
    {
        $user = $this->find($id);
       
        if ($user) {
            return $this->update($id, ['activo' => '']);
        } else {
           
            return false; 
        }
    }
}
