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
        return $this->where('curso_id', $curso_id)
        ->findAll();
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
