<?php

namespace App\Models;

use CodeIgniter\Model;

class asistenciasmodel extends Model
{
    protected $table = 'asistencia';
    protected $primaryKey = 'asistencia_id';
    protected $allowedFields = ['estudiante_id', 'nombre' ,'curso_id', 'fecha', 'presente'];

    // Función para ingresar asistencias
    public function ingresarAsistencia($datos)
    {
        // Verificamos si ya existe un registro de asistencia para el estudiante en la misma fecha y curso
        $existeAsistencia = $this->where('estudiante_id', $datos['estudiante_id'])
                                  ->where('curso_id', $datos['curso_id'])
                                  ->where('fecha', $datos['fecha'])
                                  ->first();
    
        if (empty($existeAsistencia)) {
            // Si no existe, insertamos la nueva asistencia
            $this->insert($datos);
        } else {
            // Si existe, actualizamos el registro
            $this->update($existeAsistencia['asistencia_id'], $datos);
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
    public function obtenerAsistencias(){
        return $this->db->table('asistencia')
        ->select("
            CONCAT(cursos.grado, ' ', nivel.nombre) AS nombre_curso, 
            DATE_FORMAT(asistencia.fecha, '%Y-%m') AS mes, 
            estudiantes.nombre_estudiante AS nombre_estudiante, 
            asistencia.fecha AS fecha, 
            asistencia.presente AS estado_asistencia
        ")
        ->join('estudiantes', 'estudiantes.estudiante_id = asistencia.estudiante_id')
        ->join('cursos', 'cursos.curso_id = asistencia.curso_id')
        ->join('nivel', 'nivel.nivel_id = cursos.nivel_id') // Agregamos el JOIN con la tabla nivel
        ->orderBy('cursos.grado', 'ASC') // Ordenar por grado
        ->orderBy('mes', 'ASC')          
        ->orderBy('asistencia.fecha', 'ASC')
        ->get()
        ->getResultArray();
    }
}
