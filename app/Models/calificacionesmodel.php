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
    public function guardarCalificacion($idEstudiante, $notas, $cursoId, $asignaturaId)
{
    foreach ($notas as $nota) {
        $existingCalificacion = $this->db->table('calificaciones')
            ->where('estudiante_id', $idEstudiante)
            ->where('nota', $nota)
            ->where('curso_id', $cursoId)
            ->where('asignatura_id', $asignaturaId)
            ->get()
            ->getRow();

        if ($existingCalificacion) {
            $this->actualizarCalificacion($existingCalificacion->calificacion_id, $nota);
        } else {
            $this->insertCalificacion($idEstudiante, $nota, $cursoId, $asignaturaId);
        }
    }
}

public function insertCalificacion($idEstudiante, $nota, $cursoId, $asignaturaId)
{
    $data = [
        'estudiante_id' => $idEstudiante,
        'nota' => $nota,
        'curso_id' => $cursoId,
        'asignatura_id' => $asignaturaId
    ];
    $this->db->table('calificaciones')->insert($data);
}

public function actualizarCalificacion($calificacionId, $nota)
{
    $data = [
        'nota' => $nota !== '' ? $nota : null
    ];

    $this->db->table('calificaciones')
        ->where('calificacion_id', $calificacionId)
        ->update($data);
}


public function getCalificacionesPorasignatura($asignaturaId)
{
    return $this->select('estudiantes.nombre_estudiante, estudiantes.estudiante_id , calificaciones.nota, calificaciones.asignatura_id, calificaciones.calificacion_id, calificaciones.fecha_ingreso')
        ->join('estudiantes', 'estudiantes.estudiante_id = calificaciones.estudiante_id')
        ->where('calificaciones.asignatura_id', $asignaturaId)
        ->orderBy('estudiantes.estudiante_id', 'ASC')
        ->orderBy('calificaciones.calificacion_id', 'desc')
        ->findAll();
}

    public function obtenerCalificacionesPorEstudiante($estudiante_id)
    {
        return $this
            ->where('estudiante_id', $estudiante_id)
            ->get()
            ->getResultArray();
    }
   
}
