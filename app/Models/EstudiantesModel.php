<?php

namespace App\Models;

use CodeIgniter\Model;

class EstudiantesModel extends Model
{
    protected $table = 'estudiantes';
    protected $primaryKey = 'estudiante_id';
    protected $allowedFields = ['nombre', 'fecha_nacimiento', 'grado'];

    public function obtenerEstudiantesPorCurso($curso_id)
    {
        $builder = $this->db->table('estudiantes');
        $builder->select('estudiantes.*');
        $builder->join('anotaciones', 'anotaciones.estudiante_id = estudiantes.estudiante_id');
        $builder->join('usuarios', 'usuarios.user_id = anotaciones.user_id');
        $builder->join('cursos', 'cursos.user_id = usuarios.user_id');
        $builder->where('cursos.curso_id', $curso_id);
        $query = $builder->get();
    
        return $query->getResultArray();
    }
    public function obtenerEstudiantesConApoderados()
    {
        // Obtener estudiantes con detalles de apoderados
        return $this->select('estudiantes.*, apoderados.nombre')
            ->join('apoderados', 'apoderados.estudiante_id = estudiantes.estudiante_id')
            ->findAll();
    }

    public function eliminarPorApoderado($id_Apoderado)
    {
        // Buscar estudiantes asociados a este apoderado
        $estudiantesAsociados = $this->where('id_apoderado', $id_Apoderado)->findAll();

        // Eliminar los estudiantes asociados
        foreach ($estudiantesAsociados as $estudiante) {
            $this->delete($estudiante['estudiante_id']);
        }
    }
}
