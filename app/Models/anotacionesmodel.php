<?php

namespace App\Models;

use CodeIgniter\Model;

class EstudiantesModel extends Model
{
    protected $table = 'estudiantes';

    public function obtenerEstudiantesPorCurso($curso_id)
    {
        $builder = $this->db->table('cursos');
        $builder->select('estudiantes.*');
        $builder->join('usuarios', 'usuarios.user_id = cursos.user_id');
        $builder->join('anotaciones', 'anotaciones.user_id = usuarios.user_id');
        $builder->join('estudiantes', 'estudiantes.estudiante_id = anotaciones.estudiante_id');
        $builder->where('cursos.curso_id', $curso_id);
        $query = $builder->get();

        return $query->getResultArray();
    }
}
