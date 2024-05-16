<?php

namespace App\Models;

use CodeIgniter\Model;

class EstablecimientoModel extends Model
{
    protected $table = 'establecimientos';
    protected $primaryKey = 'cod_est';
    protected $allowedFields = ['nombre_est', 'direccion_est', 'telefono_est', 'tipo_est', 'userid'];

    public function getEstablecimientosForDirective()
    {
        // Puedes personalizar esta consulta según tus necesidades
        return $this->findAll();
    }
}
