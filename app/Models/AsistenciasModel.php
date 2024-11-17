<?php

namespace App\Models;

use CodeIgniter\Model;

class AsistenciasModel extends Model
{
    protected $table = 'asistencia';
    protected $primaryKey = 'asistencia_id';
    protected $allowedFields = ['estudiante_id', 'curso_id', 'fecha', 'presente'];

    // Función para ingresar asistencias
    public function ingresarAsistencias($datos)
    {
        // Verificamos si ya existe un registro de asistencia para el estudiante en la misma fecha y curso
        $existeAsistencia = $this->where('estudiante_id', $datos['estudiante_id'])
                                  ->where('curso_id', $datos['curso_id'])
                                  ->where('fecha', $datos['fecha'])
                                  ->first();
        
        // Si no existe, insertamos la nueva asistencia
        if (empty($existeAsistencia)) {
            return $this->insert($datos);
        } else {
            return false;  // Si ya existe, no se inserta y retorna false
        }
    }

    // Obtener estudiantes presentes en una fecha determinada para un curso específico
    public function getEstudiantesPresentes($cursoId, $fecha)
    {
        return $this->db->table('asistencia AS a')
                        ->select('e.estudiante_id, e.nombre_estudiante, a.presente')
                        ->join('estudiantes AS e', 'a.estudiante_id = e.estudiante_id', 'inner')
                        ->where('a.curso_id', $cursoId)
                        ->where('a.fecha', $fecha)
                        ->where('a.presente', 1) // Filtrar solo los presentes
                        ->get()
                        ->getResultArray();
    }

    // Obtener la última fecha de asistencia registrada para un curso
    public function obtenerUltimaFechaAsistenciaPorCurso($cursoId)
    {
        return $this->select('fecha')
                    ->where('curso_id', $cursoId)
                    ->orderBy('fecha', 'DESC')
                    ->first();
    }

    // Obtener todas las asistencias por curso
    public function getAsistenciasPorCurso($cursoId)
    {
        return $this->where('curso_id', $cursoId)
                    ->findAll();
    }

    // Obtener todas las asistencias de un estudiante específico
    public function obtenerAsistenciasPorEstudiante($estudiante_id)
    {
        return $this
            ->where('estudiante_id', $estudiante_id)
            ->get()
            ->getResultArray();
    }
}
