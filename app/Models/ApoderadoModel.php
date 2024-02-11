<?php

namespace App\Models;

use CodeIgniter\Model;

class ApoderadoModel extends Model
{
    protected $table = 'apoderado';
    protected $primaryKey = 'rut_apoderado';
    protected $allowedFields = ['nombre_apoderado', 'telefono_apoderado', 'direccion_apoderado', 'fechanace_apoderado'];

    public function actualizarApoderado($rutApoderado, $data)
    {
        $this->update($rutApoderado, $data);
    }
}
