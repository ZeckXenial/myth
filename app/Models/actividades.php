<?php

namespace App\Models;

use CodeIgniter\Model;

class actividades extends Model
{
    protected $table = 'actividades';
    protected $primaryKey = 'act_id';

    protected $allowedFields = [
        'user_id', 
        'curso_id', 
        'asignatura_id', 
        'glosa', 
        'fecha_actividad'
    ];
    public function obtenerActividadesRecientesPorCursoYAsignatura($curso_id, $asignatura_id)
    {
        return $this->select('actividades.*, usuarios.nombre AS nombre_responsable')
                    ->join('usuarios', 'usuarios.user_id = actividades.user_id')
                    ->where('actividades.curso_id', $curso_id)
                    ->where('actividades.asignatura_id', $asignatura_id)
                    ->orderBy('actividades.fecha_actividad', 'DESC')
                    ->findAll();
    }
    
    
    public function obtenerActividadesPorAsignaturaYCurso($curso_id, $asignatura_id)
    {
        return $this->where('curso_id', $curso_id)
                    ->where('asignatura_id', $asignatura_id)
                    ->findAll();
    }

    public function verificarActividadDelDia($curso_id, $asignatura_id, $fecha_actividad)
    {
        return $this->select('actividades.*,nombre AS nombre_responsable')
                    ->join('usuarios', 'usuarios.user_id = actividades.user_id')
                    ->where('curso_id', $curso_id)
                    ->where('asignatura_id', $asignatura_id)
                    ->where('fecha_actividad', $fecha_actividad)
                    ->first();
    }
    public function actualizarActividad($act_id, $data)
{
    return $this->update($act_id, $data);
}

    public function insertarActividad($data)
    {
        return $this->insert($data);
    }
}
