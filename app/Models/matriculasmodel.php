<?php

namespace App\Models;

use CodeIgniter\Model;

class matriculas_model extends Model
{
    protected $table = 'matriculas';
    protected $primaryKey = 'matricula_id';
    protected $allowedFields = ['estudiante_id', 'apoderado_id', 'fecha_matriculacion', 'estado'];

   

    public function obtener_todos()
    {
        $builder = $this->db->table($this->table);
$builder->select('matriculas.*, estudiantes.nombre_estudiante, apoderado.nombre_apoderado, cursos.grado, cursos.nombre_nivel');
$builder->join('estudiantes', 'estudiantes.matricula_id = matriculas.matricula_id');
$builder->join('apoderado', 'apoderado.matricula_id = matriculas.matricula_id');
$builder->join('cursos', 'cursos.curso_id = estudiantes.curso_id'); // Asumiendo que estudiantes tiene el campo curso_id
return $builder->get()->getResult();

    }

    public function obtener_por_id($estudiante_id, $apoderado_id)
    {
        $builder = $this->db->table($this->table);
        $builder->select('matriculas.*, estudiantes.*, apoderados.*, apoderados.rut as rut_apoderado, estudiantes.rut as rut_estudiantes');
        $builder->join('estudiantes', 'estudiantes.estudiante_id = matriculas.estudiante_id');
        $builder->join('apoderados', 'apoderados.apoderado_id = matriculas.apoderado_id');
        $builder->where('matriculas.estudiante_id', $estudiante_id);
        $builder->where('matriculas.apoderado_id', $apoderado_id);
    
        return $builder->get()->getRow();
    }
    
}
