<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = 'usuarios'; // Cambiar 'users' por 'usuarios'

    public function getUserData($username)
    {
        return $this->db->table($this->table)
            ->where('email', $username)
            ->get()
            ->getRow();
    }

    public function submit_login($username, $password)
    {
        $user = $this->getUserData($username);

        return $user && password_verify($password, $user->password) ? $user->id_rol : null;
    }

    public function getFullName($username)
    {
        $user = $this->getUserData($username);

        return $user ? $user->nombre : null;
    }

    public function getIdUser($username)
    {
        $user = $this->getUserData($username);

        return $user ? $user->user_id : null;
    }
}
