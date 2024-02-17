<?php

namespace App\Models;

use CodeIgniter\Model;

class AsistenciasModel extends Model
{
    protected $table = 'asistencia';
    protected $primaryKey = 'asistencia_id';
    protected $allowedFields = ['estudiante_id', 'curso_id', 'fecha', 'presente'];

    public function getAsistenciasPorCurso($clase_id)
    {
        return $this->where('curso_id', $clase_id)
                    ->findAll();
    }

    public function ingresarAsistencias($datos)
{
    if (is_array($datos) && isset($datos[0]) && is_array($datos[0])) {
        return $this->insertBatch($datos);
    } else {
        return $this->insert($datos);
    }
}
}
