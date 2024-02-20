<?php

namespace App\Models;

use CodeIgniter\Model;

class ApoderadoModel extends Model
{
    protected $table = 'apoderados';
    protected $primaryKey = 'apoderados_id';
    protected $allowedFields = ['nombre', 'estudiante_id', 'numero_telefono', 'email'];

    public function obtenerApoderados()
    {
        return $this->findAll();
    }

    public function obtenerApoderado($id)
    {
        return $this->find($id);
    }

    public function crearApoderado($data)
    {
        return $this->insert($data);
    }

    public function actualizarApoderado($id, $data)
    {
        return $this->update($id, $data);
    }

    public function eliminarApoderado($id)
    {
        return $this->delete($id);
    }
}
