<?php

namespace App\Models;

use CodeIgniter\Model;

class AsignaturaCursoModel extends Model
{
    protected $table = 'cursos_asignaturas';
    protected $primaryKey = 'curso_id'; // Ajusta el nombre del campo si es diferente en tu base de datos
    protected $allowedFields = ['curso_id', 'asignatura_id'];

    // Insertar un solo registro
    public function insertarAsignaturaCurso($curso_id, $asignatura_id)
    {
        $data = [
            'curso_id' => $curso_id,
            'asignatura_id' => $asignatura_id
        ];

        return $this->insert($data);
    }

    public function insertarMultiplesAsignaturasCurso($curso_id, $asignaturas)
    {
        $data = [];
        foreach ($asignaturas as $asignatura_id) {
            $data[] = [
                'curso_id' => $curso_id,
                'asignatura_id' => $asignatura_id
            ];
        }

        return $this->insertBatch($data);
    }

    public function eliminarAsignaturaCurso($id)
    {
        return $this->delete($id);
    }

    // Eliminar registros por curso_id
    public function eliminarAsignaturasCursoPorCursoId($curso_id)
    {
        return $this->where('curso_id', $curso_id)->delete();
    }
}
