<?php
namespace App\Models;

use CodeIgniter\Model;

class EstudiantesModel extends Model
{
    protected $table = 'estudiantes';
    protected $primaryKey = 'rut_estudiante';
    protected $allowedFields = ['rut_estudiante', 'nombre_estudiante', 'cod_est', 'rut_apoderado', 'fecha_nace', 'id_curso'];

    // ...

    public function obtenerEstudiantesConApoderados()
    {
        // Obtener estudiantes con detalles de apoderados
        return $this->select('estudiantes.*, apoderados.nombre_apoderado')
            ->join('apoderados', 'apoderados.rut_apoderado = estudiantes.rut_apoderado')
            ->findAll();
    }
    public function eliminarPorApoderado($rutApoderado)
    {
        // Buscar estudiantes asociados a este apoderado
        $estudiantesAsociados = $this->where('rut_apoderado', $rutApoderado)->findAll();

        // Eliminar los estudiantes asociados
        foreach ($estudiantesAsociados as $estudiante) {
            $this->delete($estudiante['rut_estudiante']);
        }
    }

}
