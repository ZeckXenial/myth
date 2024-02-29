<?php

namespace App\Models;

use CodeIgniter\Model;

class apoderado_estudiante extends Model
{
    protected $table = 'estudiantes_apoderados';
    protected $primaryKey = 'estudiantes_id'; 
    protected $allowedFields = ['estudiantes_id', 'apoderados_id'];

    public function obtenerEstudiantesConApoderados()
    {
        return $this->select('apoderados.apoderados_id,estudiante_id,nombre_estudiante,fecha_nacimiento,curso_id,nombre_apoderado,numero_telefono,email')
            ->join('estudiantes', 'estudiantes.estudiante_id = estudiantes_apoderados.estudiantes_id')
            ->join('apoderados', 'apoderados.apoderados_id = estudiantes_apoderados.apoderados_id')
            ->findAll();
    }
    public function insertEstudianteApoderado($estudianteId, $apoderadoId)
{
    $data = [
        'estudiantes_id' => $estudianteId,
        'apoderados_id' => $apoderadoId,
    ];
    return $this->db->table('estudiantes_apoderados')->insert($data);
}

}
