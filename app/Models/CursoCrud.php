<?php

namespace App\Models;

use CodeIgniter\Model;

class CursoModel extends Model
{
    protected $table = 'cursos';
    protected $primaryKey = 'curso_id';
    protected $allowedFields = ['user_id', 'asignatura_id', 'grado', 'activo'];

    public function obtenerCursos()
    {
        return $this->findAll();
    }

    public function obtenerCursoPorId($id)
    {
        return $this->find($id);
    }

    public function crearCurso($data)
    {
        return $this->insert($data);
    }

    public function actualizarCurso($id, $data)
    {
        return $this->update($id, $data);
    }

    public function eliminarCurso($id)
    {
        return $this->delete($id);
    }
}
