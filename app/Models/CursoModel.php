<?php

namespace App\Models;

use CodeIgniter\Model;

class CursoModel extends Model
{
    protected $table = 'cursos';
    protected $primaryKey = 'id_curso';
    protected $allowedFields = ['cod_est', 'nombre_curso', 'nivel_curso', 'iduser'];

    public function obtenerCursos()
    {
        $codEstablecimiento = session()->get('cod_est');
        
        if (session()->get('role') === 'teacher') {
            $idProfesor = session()->get('iduser');
            return $this->getCursosByTeacher($idProfesor);
        } elseif (session()->get('role') === 'directive') {
            return $this->getCursosByEstablecimiento($codEstablecimiento);
        }
        return [];
    }

    public function getCursosByEstablecimiento($codEstablecimiento)
    {
        return $this->where('cod_est', $codEstablecimiento)->findAll();
    }

    public function getCursosByTeacher($idProfesor)
    {
        return $this->where('iduser', $idProfesor)
            ->where('iduser IS NOT NULL', null, false)
            ->findAll();
    }
}
