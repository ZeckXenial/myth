<?php

namespace App\Models;

use CodeIgniter\Model;

class EstudiantesModel extends Model
{
    protected $table = 'estudiantes';

    public function obtenerEstudiantesPorCurso($curso_id)
    {
        return $this->where('curso_id', $curso_id)
        ->findAll();
    }
}
