<?php

namespace App\Models;

use CodeIgniter\Model;

class estudiantesmodel extends Model
{
    protected $table = 'estudiantes';
    protected $primaryKey = 'estudiante_id';
    protected $allowedFields = ['nombre_estudiante', 'fecha_nacimiento', 'curso_id'];

    public function obtenerEstudiantesPorCurso($curso_id)
    {
        return $this->where('curso_id', $curso_id)
        ->findAll();
    }
    public function obtenerEstudiantesConApoderados()
    {
       
        return $this->select('estudiantes.*, apoderados.nombre')
            ->join('apoderados', 'apoderados.estudiante_id = estudiantes.estudiante_id')
            ->findAll();
    }
    public function obtenerEstudiantes()
    {
        return $this->findAll();
    }

    
    public function obtenerEstudiantePorId($id)
    {
        return $this->find($id);
    }
 

    public function crearEstudiante($data)
    {
        return $this->insert($data);
    }

    public function actualizarEstudiante($id, $data)
    {
        return $this->update($id, $data);
    }

    public function eliminarEstudiante($id)
    {
        return $this->delete($id);
    }
    public function eliminarPorApoderado($id_Apoderado)
    {
        $estudiantesAsociados = $this->where('id_apoderado', $id_Apoderado)->findAll();

        foreach ($estudiantesAsociados as $estudiante) {
            $this->delete($estudiante['estudiante_id']);
        }
    }

    

   

    
}

