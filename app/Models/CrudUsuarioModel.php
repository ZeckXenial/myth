<?php

namespace App\Models;

use CodeIgniter\Model;

class crudusuariomodel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'user_id';
    protected $allowedFields = ['nombre', 'email', 'password', 'id_rol', 'especialidad','activo'];

    public function obtenerUsuariosConRoles()
    {
        return $this->db->table('usuarios')
            ->select('usuarios.user_id,usuarios.nombre,usuarios.email,usuarios.especialidad,usuarios.id_rol ,roles.glosa as nombre_rol')
            ->join('roles', 'roles.id_rol = usuarios.id_rol')
            ->where('activo', null)
            ->get()
            ->getResultArray();
    }
    public function obtenerprofesores()
    {
        return $this->db->table('usuarios')
            ->select('usuarios.user_id,usuarios.nombre,usuarios.email,usuarios.id_rol ')
            ->where('activo', null)
            ->where('id_rol' , '1')
            ->get()
            ->getResultArray();
    }
    public function obtenerUsuarios()
    {
        return $this->db->table('usuarios')
            ->select('usuarios.nombre,usuarios.user_id')
            ->where('activo', null)
            ->get()
            ->getResultArray();
    }
    public function obtenerUsuarioPorId($id)
    {
        return $this->db->table('usuarios')
        ->select('usuarios.nombre,usuarios.user_id, usuarios.email, usuarios.especialidad')
        ->where('activo', null)
        ->where('user_id', $id)
        ->get()
        ->getRowArray();
    }

    public function agregarUsuario($datos)
    {
        return $this->insert($datos);
    }

    

    public function actualizarUsuario($id, $datos)
    {
        return $this->db->table('usuarios')
            ->where('user_id', $id)
            ->update($datos);
    }

    public function editarUsuario($id, $datos)
    {
        return $this->update($id, $datos);
    }

    public function eliminarUsuario($id)
{
    $user = $this->find($id);

    if ($user) {
        $random = bin2hex(random_bytes(8)); 
        $uniqueString = $random . '_' . $id . '_' . time(); 

        return $this->update($id, ['activo' => '', 'email' => $uniqueString]);
    } else {
        return false; 
    }
}
}
