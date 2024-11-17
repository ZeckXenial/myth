<?php

namespace App\Models;

use CodeIgniter\Model;

class AnotacionesModel extends Model
{
    protected $table = 'anotaciones';
    protected $primaryKey = 'anotacion_id';
    protected $allowedFields = ['estudiante_id', 'curso_id','user_id', 'origen_anot','grado','glosa_anot','fecha_anotacion'];

    public function crearAnotacion($data)
    {
        return $this->insert($data);
    }

    public function editarAnotacion($anotacion_id, $data)
    {
        return $this->update($anotacion_id, $data);
    }

    public function eliminarAnotacion($anotacion_id)
    {
        return $this->delete($anotacion_id);
    }
 
    public function obtenerAnotacionesPorEstudiante($estudiante_id)
    {
        return $this
            ->where('estudiante_id', $estudiante_id)
            ->get()
            ->getResultArray();
    }
}

