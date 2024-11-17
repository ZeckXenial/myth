<?php

namespace App\Models;

use CodeIgniter\Model;

class CalificacionesModel extends Model
{
    protected $table = 'calificaciones';
    protected $primaryKey = 'calificacion_id';
    protected $allowedFields = ['estudiante_id', 'curso_id', 'asignatura_id', 'nota', 'user_id', 'fecha_ingreso', 'evaluacion_id'];

    /**
     * Obtener las calificaciones por curso.
     */
    public function getCalificacionesPorCurso($cursoId)
    {
        return $this->where('curso_id', $cursoId)->findAll();
    }
    public function buscarCalificacion($estudiante_id, $evaluacion_id)
    {
        return $this->where('estudiante_id', $estudiante_id)
                    ->where('evaluacion_id', $evaluacion_id)
                    ->first(); // Devuelve la primera coincidencia
    }
    /**
     * Guardar calificación (si no existe, la inserta, si existe, la actualiza).
     */
/*     public function guardarCalificacion($estudianteId, $notas, $cursoId, $asignaturaId, $userId, $evaluacionId)
    {
        foreach ($notas as $nota) {
            $existingCalificacion = $this->db->table('calificaciones')
                ->where('estudiante_id', $estudianteId)
                ->where('evaluacion_id', $evaluacionId)
                ->get()
                ->getRow();

            if ($existingCalificacion) {
                $this->actualizarCalificacion($existingCalificacion->calificacion_id, $nota);
            } else {
                $this->insertCalificacion($estudianteId, $nota, $cursoId, $asignaturaId, $userId, $evaluacionId);
            }
        }
    } */

    /**
     * Insertar una nueva calificación.
     */
    public function insertCalificacion($data)
    {
        $resultado = $this->db->table('calificaciones')->insert($data);
        
        return $resultado; 
    }
    public function obtenerCalificacionesPorEstudiante($estudiante_id)
    {
        return $this->select('calificaciones.nota, asignaturas.nombre_asignatura, calificaciones.fecha_ingreso')
            ->join('asignaturas', 'asignaturas.asignatura_id = calificaciones.asignatura_id')
            ->where('calificaciones.estudiante_id', $estudiante_id)
            ->get()
            ->getResultArray();
    }
    
    /**
     * Actualizar una calificación existente.
     */
    public function actualizarCalificacion($calificacionId, $nota)
    {
        $data = [
            'nota' => $nota !== '' ? $nota : 0 
        ];
    
        $resultado = $this->db->table('calificaciones')
            ->where('calificacion_id', $calificacionId)
            ->update($data);
    
        return $resultado; // Retorna true si la actualización fue exitosa, false si falló
    }

    /**
     * Obtener calificaciones por asignatura.
     */
    public function getCalificacionesPorAsignatura($asignaturaId)
    {
        return $this->select('estudiantes.*,calificaciones.*')
            ->join('estudiantes', 'estudiantes.estudiante_id = calificaciones.estudiante_id')
            ->where('calificaciones.asignatura_id', $asignaturaId)
            ->orderBy('estudiantes.estudiante_id', 'ASC')
            ->orderBy('calificaciones.calificacion_id', 'desc')
            ->findAll();
    }

    /**
     * Guardar varias calificaciones en una transacción.
     */
    public function guardarCalificacionesEnLote($calificaciones)
    {
        $this->db->transStart();
        foreach ($calificaciones as $calificacion) {
            $this->insert($calificacion);
        }
        $this->db->transComplete();

        return $this->db->transStatus();
    }


    /**
     * Obtener calificaciones de un estudiante específico.
     */
    public function obtenerCalificacionesPorFecha($cursoId, $asignaturaId)
    {
        return $this->select('calificaciones.*, estudiantes.nombre_estudiante, evaluaciones.numero_evaluacion, evaluaciones.evaluacion_id')
                    ->join('estudiantes', 'estudiantes.estudiante_id = calificaciones.estudiante_id')
                    ->join('evaluaciones', 'evaluaciones.evaluacion_id = calificaciones.evaluacion_id')
                    ->where('calificaciones.curso_id', $cursoId)
                    ->where('calificaciones.asignatura_id', $asignaturaId)
                    ->orderBy('calificaciones.fecha_ingreso', 'DESC')
                    ->findAll();
    }
    
}
