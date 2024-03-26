<?php

namespace App\Models;

use CodeIgniter\Model;

class AsignaturaCursoModel extends Model
{
    protected $table = 'cursos_asignaturas';
    protected $primaryKey = 'id'; 
    protected $allowedFields = ['curso_id', 'asignatura_id'];

    public function insertarAsignaturaCurso($curso_id, $asignatura_id)
    {
        $data = [
            'curso_id' => $curso_id,
            'asignatura_id' => $asignatura_id
        ];
    
        return $this->insert($data);
    }
    public function eliminarAsignaturaCurso($id)
    {
        return $this->delete($id);
    }
    public function eliminarAsignaturasCursoPorCursoId($curso_id)
    {
        return $this->where('curso_id', $curso_id)->delete();
    }
}    
