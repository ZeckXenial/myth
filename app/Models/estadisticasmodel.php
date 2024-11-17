<?php

namespace App\Models;

use CodeIgniter\Model;

class EstadisticasModel extends Model
{
    protected $table = ''; 

   public function getAsistenciasPorCurso()
{
    return $this->db->table('asistencia AS a')
                    ->select('c.curso_id, c.grado AS curso, n.nombre AS nivel, COUNT(a.asistencia_id) AS total_asistencias')
                    ->join('cursos AS c', 'a.curso_id = c.curso_id', 'inner')
                    ->join('nivel AS n', 'c.nivel_id = n.nivel_id', 'inner')  // Join con la tabla nivel
                    ->where('a.presente', 1)  // Solo contar las asistencias donde 'presente' sea 1
                    ->groupBy('c.curso_id')
                    ->orderBy('n.nombre', 'ASC')  // Ordenar por el nombre del nivel
                    ->get()
                    ->getResultArray();
}
    // Contar las matrículas con estado 'matriculado'
    public function getTotalMatriculas()
{
    return $this->db->table('matriculas')
                    ->select("DATE_FORMAT(fecha_matriculacion, '%Y-%m-%d') AS fecha, COUNT(*) AS total_matriculados")  // Agrupamos por fecha
                    ->where('estado', 'matriculado')
                    ->groupBy('fecha')  // Agrupamos por fecha
                    ->orderBy('fecha', 'ASC')  // Ordenamos por fecha
                    ->get()
                    ->getResultArray();
}


    // Obtener anotaciones agrupadas por mes
    public function getAnotacionesPorMes()
    {
        return $this->db->table('anotaciones')
                        ->select("DATE_FORMAT(fecha_anotacion, '%Y-%m') AS mes, COUNT(*) AS total_anotaciones")
                        ->groupBy('mes')
                        ->orderBy('mes', 'ASC')
                        ->get()
                        ->getResultArray();
    }
    public function obtenerValidaciones() {

        return $this->db->table('validacion as v')
        ->select('v.val_id , v.status, v.user_id, v.fecha_val, u.nombre as usuario_nombre')
        ->join('usuarios u', 'v.user_id = u.user_id', 'inner')
        ->orderBy('v.fecha_val', 'ASC')
        ->get()
        ->getResultArray();
        
    }
    // Calcular el promedio de calificaciones por curso
    public function getPromedioCalificacionesPorCurso()
    {
        return $this->db->table('calificaciones AS c')
                        ->select('c.curso_id, cu.grado AS curso, AVG(c.nota) AS promedio_calificaciones')
                        ->join('cursos AS cu', 'c.curso_id = cu.curso_id', 'inner')
                        ->groupBy('c.curso_id')
                        ->orderBy('promedio_calificaciones', 'DESC')
                        ->get()
                        ->getResultArray();
    }

}
