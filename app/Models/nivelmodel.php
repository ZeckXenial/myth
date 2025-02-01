<?php

namespace App\Models;

use CodeIgniter\Model;

class nivelmodel extends Model
{
    protected $table = 'nivel';
    protected $primaryKey = 'nivel_id';
    protected $allowedFields = ['nombre', 'letra'];

    public function obtenerNiveles()
    {
        return $this->findAll();
    }

    public function obtenerNivelPorId($id)
    {
        return $this->find($id);
    }
}
