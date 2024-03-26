<?php

namespace App\Models;

use CodeIgniter\Model;

class AsignaturaModel extends Model
{
    protected $table = 'asignaturas';
    protected $primaryKey = 'asignatura_id';
    protected $allowedFields = ['nombre_asignatura', 'user_id' ];

    public function obtenerAsignaturas($cursoId)
    {
        $user_id = session()->get('user_id');
    $idrol = session()->get('idrol');

    if ($idrol === '2' || $idrol === '3') {
      
        $query = $this->select('asignaturas.*, usuarios.nombre AS nombre_usuario')
        ->join('usuarios', 'usuarios.user_id = asignaturas.user_id')
        ->findAll();

$asignaturas_relacionadas = $this->db->table('cursos_asignaturas')
                               ->select('asignatura_id')
                               ->where('curso_id', $cursoId)
                               ->get()
                               ->getResultArray();

$asignaturas_ids = array_column($asignaturas_relacionadas, 'asignatura_id');

foreach ($query as &$asignatura) {
if (in_array($asignatura['asignatura_id'], $asignaturas_ids)) {
  $asignatura['selected'] = true;
} else {
  $asignatura['selected'] = false;
}
}

return $query;
    } else {
     
        $asignaturas_usuario = $this->select('asignaturas.*')
        ->join('cursos_asignaturas', 'cursos_asignaturas.asignatura_id = asignaturas.asignatura_id')
        ->join('cursos', 'cursos.curso_id = cursos_asignaturas.curso_id')
        ->where('cursos.user_id', $user_id)
        ->orWhere('cursos_asignaturas.user_id', $user_id)
        ->groupBy('asignaturas.asignatura_id')
        ->findAll();

// Obtener las asignaturas relacionadas con el curso actual
$asignaturas_relacionadas_curso = $this->db->table('cursos_asignaturas')
                       ->select('asignatura_id')
                       ->where('curso_id', $cursoId)
                       ->get()
                       ->getResultArray();

// Convertir el resultado en un array de IDs de asignaturas
$asignaturas_ids = array_column($asignaturas_relacionadas_curso, 'asignatura_id');

// Marcar las asignaturas relacionadas con el curso como seleccionadas
foreach ($asignaturas_usuario as &$asignatura) {
if (in_array($asignatura['asignatura_id'], $asignaturas_ids)) {
$asignatura['selected'] = true;
} else {
$asignatura['selected'] = false;
}
}

return $asignaturas_usuario;
    }
    }

    public function obtenerAsignaturaPorId($id)
    {
        return $this->find($id);
    }

    public function crearAsignatura($data)
    {
        return $this->insert($data);
    }

    public function actualizarAsignatura($id, $data)
    {
        return $this->update($id, $data);
    }

    public function eliminarAsignatura($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('calificaciones');
        $builder->where('asignatura_id', $id);
        $builder->delete();
    
        $builder = $db->table('cursos_asignaturas');
        $builder->where('asignatura_id', $id);
        $builder->delete();
        
        $this->delete($id);
        return true; 
    }
}
