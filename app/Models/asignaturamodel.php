<?php

namespace App\Models;

use CodeIgniter\Model;

class AsignaturaModel extends Model
{
    protected $table = 'asignaturas';
    protected $primaryKey = 'asignatura_id';
    protected $allowedFields = ['nombre_asignatura', 'user_id' ];

    public function obtenerAsignaturas()
    {
        return $this->findAll();
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
        return $this->delete($id);
    }
}
