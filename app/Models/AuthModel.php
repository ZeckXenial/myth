<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = 'users';
    protected $tableest = 'establecimientos';

    public function getUserData($username)
    {
        return $this->db->table($this->table)
            ->join($this->tableest, "$this->table.cod_est = $this->tableest.cod_est")
            ->where('email', $username)
            ->get()
            ->getRow();
    }

    public function submit_login($username, $password)
    {
        $user = $this->getUserData($username);

        return $user ? $user->role : null;
    }

    public function NombreUsuario($username)
    {
        $user = $this->getUserData($username);

        return $user ? $user->full_name : null;
    }

    public function Establecimiento($username)
    {
        $user = $this->getUserData($username);

        return $user ? $user->nombre_est : null;
    }

    public function Codigo_Establecimiento($username)
    {
        $user = $this->getUserData($username);

        return $user ? $user->cod_est : null;
    }

    public function iduser($username)
    {
        $user = $this->getUserData($username);

        return $user ? $user->iduser : null;
    }
}
