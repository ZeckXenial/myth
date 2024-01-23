<?php

namespace App\Models;

use CodeIgniter\Model;

class AnotacionesModel extends Model
{
    protected $table = 'anotaciones';
    protected $primaryKey = 'Id_anotacion';
    protected $allowedFields = ['Rut_estudiante', 'descripcion', 'fecha_anotacion'];

    // Obtener anotaciones por estudiante
    public function obtenerAnotacionesPorEstudiante($rutEstudiante)
    {
        return $this->where('Rut_estudiante', $rutEstudiante)->findAll();
    }

    public function getAnotacionesPorCurso($cursoId)
    {
       // Agrega una JOIN para obtener el nombre del estudiante
       $builder = $this->db->table('anotaciones');
       $builder->select('anotaciones.*, estudiantes.nombre_estudiante');
       $builder->join('estudiantes', 'estudiantes.rut_estudiante = anotaciones.rut_estudiante');
       $builder->where('estudiantes.id_curso', $cursoId);

       return $builder->get()->getResultArray();
    }
    // Guardar una nueva anotación
    public function guardarAnotacion($data)
    {
        return $this->insert($data);
    }
}
