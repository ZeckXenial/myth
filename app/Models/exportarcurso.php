<?php

namespace App\Models;

use CodeIgniter\Model;

class exportarcurso extends Model
{
    
    
    public function obtenerDatosGenerales($cursoId)
    {
        $sql = "
        SELECT DISTINCT 
            e.nombre_estudiante,
            a.fecha AS fecha_asistencia,
            a.presente,
            c.nota,
            c.fecha_ingreso,
            asg.nombre_asignatura,
            an.origen_anot,
            an.glosa_anot,
            an.fecha_anotacion,
            ev.descripcion AS descripcion_evaluacion
        FROM asistencia AS a
        LEFT JOIN estudiantes AS e ON a.estudiante_id = e.estudiante_id
        LEFT JOIN calificaciones AS c ON c.estudiante_id = e.estudiante_id AND c.curso_id = a.curso_id
        LEFT JOIN asignaturas AS asg ON asg.asignatura_id = c.asignatura_id
        LEFT JOIN anotaciones AS an ON an.estudiante_id = e.estudiante_id AND an.curso_id = a.curso_id
        LEFT JOIN evaluaciones AS ev ON ev.evaluacion_id = c.evaluacion_id
        WHERE a.curso_id = ?
        ORDER BY e.nombre_estudiante ASC
    ";

    // Ejecuta la consulta y pasa los parámetros
    $query = $this->db->query($sql, [$cursoId]);
    
    // Devuelve los resultados como un array
    return $query->getResultArray();
    }
}
