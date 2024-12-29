<?php

namespace App\Models;

use CodeIgniter\Model;

class AsignaturasEstaticasModel extends Model
{
    protected $table = 'asignaturas_estaticas';
    protected $primaryKey = 'asignatura_id';
    protected $allowedFields = ['nombre_asignatura'];

    public function obtenerTodasAsignaturas()
    {
        return $this->findAll(); // Devuelve todas las asignaturas
    }
}
