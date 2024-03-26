<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = 'usuarios';

    public function getUserData($username)
    {
        return $this->db->table($this->table)
            ->where('email', $username)
            ->get()
            ->getRow();
    }

    public function getCourseOrSubjectId($userId)
{
    $courseId = $this->db->table('cursos')
        ->select('curso_id')
        ->where('user_id', $userId)
        ->get()
        ->getRow();

    if ($courseId) {
        return ['id' => $courseId->curso_id, 'type' => 'curso'];
    } else {
        $subjectId = $this->db->table('asignaturas')
            ->select('asignatura_id')
            ->where('user_id', $userId)
            ->get()
            ->getRow();

        if ($subjectId) {
            return ['id' => $subjectId->asignatura_id, 'type' => 'asignatura'];
        } else {
            return null;
        }
    }
}

    public function getRoleName($roleId)
    {
        $query = $this->db->query("SELECT glosa FROM roles WHERE id_rol = $roleId");
        $row = $query->getRow();
        return $row ? $row->glosa : null;
    }

    public function getUsersWithRole()
    {
        return $this->db->table('usuarios')
            ->select('usuarios.*, roles.glosa AS role')
            ->join('roles', 'roles.id_rol = usuarios.id_rol')
            ->get()
            ->getResultArray();
    }

    public function verifyPassword($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }

    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
