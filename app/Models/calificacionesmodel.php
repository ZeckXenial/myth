<?php

namespace App\Models;

use CodeIgniter\Model;

class CalificacionesModel extends Model
{
    protected $table = 'calificaciones';
    protected $primaryKey = 'calificacion_id';
    protected $allowedFields = ['estudiante_id', 'curso_id', 'asignatura_id', 'nota'];

    public function getCalificacionesPorCurso($cursoId)
    {
        return $this->where('curso_id', $cursoId)->findAll();
    }
    
}
