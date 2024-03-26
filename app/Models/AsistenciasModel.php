<?php

namespace App\Models;

use CodeIgniter\Model;

class AsistenciasModel extends Model
{
    protected $table = 'asistencia';
    protected $primaryKey = 'asistencia_id';
    protected $allowedFields = ['estudiante_id', 'curso_id', 'fecha', 'presente'];


    public function ingresarAsistencias($datos)
{
    if (is_array($datos) && isset($datos[0]) && is_array($datos[0])) {
        return $this->insertBatch($datos);
    } else {
        return $this->insert($datos);
    }
}
public function obtenerUltimaFechaAsistenciaPorCurso($cursoId)
{
    return $this->select('fecha')
                ->where('curso_id', $cursoId)
                ->orderBy('fecha', 'DESC')
                ->first();
}

public function getAsistenciasPorCurso($cursoId)
{
    return $this->where('curso_id', $cursoId)
                ->findAll();
}

public function obtenerAsistenciasPorEstudiante($estudiante_id)
{
    return $this
        ->where('estudiante_id', $estudiante_id)
        ->get()
        ->getResultArray();
}
}
