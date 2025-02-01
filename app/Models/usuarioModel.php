<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'user_id'; // Clave primaria
    protected $allowedFields = ['nombre', 'email', 'password', 'id_rol']; // Campos permitidos para inserción

    // Método para obtener todos los usuarios
    public function getAllUsers() {
        return $this->findAll();
    }

    // Método para obtener un usuario por ID
    public function getUserById($id) {
        return $this->find($id);
    }
    public function getProfesores() {
        return $this->where('id_rol', 1)->findAll(); // 1 es el rol de profesor
    }
    // Método para obtener usuarios por rol
    public function getUsersByRole($role) {
        return $this->where('id_rol', $role)->findAll();
    }

    // Método para verificar credenciales de inicio de sesión
    public function verifyCredentials($email, $password) {
        $user = $this->where('email', $email)->first();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }
}