<?php

namespace App\Models;

use CodeIgniter\Model;

class AnotacionesModel extends Model
{
    protected $table = 'anotaciones';
    protected $primaryKey = 'anotacion_id';
    protected $allowedFields = ['estudiante_id', 'user_id', 'origen_anot', 'glosa_anot'];

    // Obtener anotaciones por estudiante
    public function obtenerAnotacionesPorEstudiante($estudianteId)
    {
        return $this->where('estudiante_id', $estudianteId)->findAll();
    }

    // Obtener anotaciones por curso
    public function obtenerAnotacionesPorCurso($cursoId)
    {
        return $this->select('anotaciones.*, estudiantes.nombre')
            ->join('estudiantes', 'estudiantes.estudiante_id = anotaciones.estudiante_id')
            ->join('clases', 'clases.user_id = anotaciones.user_id')
            ->where('clases.clase_id', $cursoId)
            ->findAll();
    }

    // Guardar una nueva anotación
    public function guardarAnotacion($data)
    {
        return $this->insert($data);
    }
}
