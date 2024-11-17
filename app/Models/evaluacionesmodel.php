<?php

namespace App\Models;

use CodeIgniter\Model;

class EvaluacionesModel extends Model
{
    protected $table = 'evaluaciones';
    protected $primaryKey = 'evaluacion_id';
    
    protected $allowedFields = [
        'asignatura_id',
        'curso_id',
        'numero_evaluacion',
        'fecha_evaluacion',
        'descripcion',
        'semestre'
    ];
// EvaluacionesModel.php

public function obtenerEvaluaciones($cursoId, $asignaturaId)
{
    return $this->where('curso_id', $cursoId)
                ->where('asignatura_id', $asignaturaId)
                ->orderBy('fecha_evaluacion', 'DESC')
                ->findAll();
}


    /**
     * Método para obtener evaluaciones por curso y asignatura.
     */
    public function obtenerEvaluacionesPorCursoYAsignatura($cursoId, $asignaturaId)
    {
        return $this->where('curso_id', $cursoId)
                    ->where('asignatura_id', $asignaturaId)
                    ->findAll();
    }

    /**
     * Método para obtener evaluaciones activas (fecha de evaluación <= hoy).
     */
    public function obtenerEvaluacionesActivas($cursoId, $asignaturaId)
    {
        return $this->where('curso_id', $cursoId)
                    ->where('asignatura_id', $asignaturaId)
                    ->where('fecha_evaluacion <=', date('Y-m-d'))  // Evaluaciones pasadas o actuales
                    ->orderBy('fecha_evaluacion', 'DESC')
                    ->findAll();
    }

    /**
     * Método para guardar una nueva evaluación.
     */
    public function guardarEvaluacion($data)
    {
        return $this->insert($data);
    }

    /**
     * Método para actualizar una evaluación existente.
     */
    public function actualizarEvaluacion($evaluacionId, $data)
    {
        return $this->update($evaluacionId, $data);
    }
}
