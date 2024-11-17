<?php

namespace App\Models;

use CodeIgniter\Model;

class apoderado_estudiante extends Model
{
    protected $table = 'estudiantes_apoderados';
    protected $primaryKey = 'estudiante_id'; 
    protected $allowedFields = ['estudiante_id', 'apoderado_id'];

    public function obtenerEstudiantesConApoderados()
    {
        return $this->select('apoderados.apoderado_id,estudiantes.estudiante_id,nombre_estudiante,fecha_nacimiento,curso_id,nombre_apoderado,numero_telefono,email')
            ->join('estudiantes', 'estudiantes.estudiante_id = estudiantes_apoderados.estudiante_id')
            ->join('apoderados', 'apoderados.apoderado_id = estudiantes_apoderados.apoderado_id')
            ->findAll();
    }
    public function insertEstudianteApoderado($estudianteId, $apoderadoId)
{
    $data = [
        'estudiante_id' => $estudianteId,
        'apoderado_id' => $apoderadoId,
    ];
    return $this->db->table('estudiantes_apoderados')->insert($data);
}

}
