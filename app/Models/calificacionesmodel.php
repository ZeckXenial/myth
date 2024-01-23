<?php

namespace App\Models;

use CodeIgniter\Model;

class CalificacionesModel extends Model
{
    protected $table = 'calificaciones';
    protected $primaryKey = 'Id_calificacion';
    protected $allowedFields = ['Rut_estudiante', 'materia', 'nota', 'semestre', 'fecha_ingreso', 'id_curso', 'nivel_curso'];

    public function getCalificacionesPorCurso($cursoId)
    {
        return $this->select('calificaciones.*, estudiantes.nombre_estudiante')
            ->join('estudiantes', 'estudiantes.rut_estudiante = calificaciones.Rut_estudiante')
            ->where('calificaciones.id_curso', $cursoId)
            ->findAll();
    }
    public function actualizarCalificacion($idCalificacion, $nuevaNota)
    {
        // Validar que la nueva nota no tenga más de dos caracteres
        if (strlen($nuevaNota) > 2) {
            return false; // Si la nota es inválida, retorna false
        }

        // Validar y procesar otros datos si es necesario

        // Actualizar la calificación en la base de datos
        return $this->update($idCalificacion, ['nota' => $nuevaNota]);
    }
}
