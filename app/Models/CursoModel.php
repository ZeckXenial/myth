<?php

namespace App\Models;

use CodeIgniter\Model;

class CursoModel extends Model
{
    protected $table = 'cursos';
    protected $primaryKey = 'curso_id';
    protected $allowedFields = ['user_id', 'asignatura_id', 'grado', 'activo']; // Añadimos el campo 'activo'

    public function obtenerCursos()
    {
        $user_id = session()->get('user_id');
        
        if (session()->get('idrol') === '1') {
            return $this->getCursosByTeacher($user_id);
        } elseif (session()->get('idrol') === '2' or session()->get('idrol') === '3') {
            return $this->getCursosByDirective();
        }
        
        return [];
    }
    public function countCursos()
    {
        return $this->countAll();
    }

   
    public function getCursosByTeacher($user_id)
    {
        return $this->select('cursos.*, usuarios.nombre AS nombre_usuario')
                    ->join('usuarios', 'usuarios.user_id = cursos.user_id')
                    ->where('cursos.user_id', $user_id)
                    ->findAll();
    }

    public function getCursosByDirective()
    {
        return $this->select('cursos.*, usuarios.nombre AS nombre_usuario')
        ->join('usuarios', 'usuarios.user_id = cursos.user_id')
       
        ->findAll();
    }
}
