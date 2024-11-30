<?php

namespace App\Models;

use CodeIgniter\Model;

class cursomodel extends Model
{
    protected $table      = 'cursos';
    protected $primaryKey = 'curso_id';
    protected $allowedFields = ['user_id', 'estado','asignatura_id', 'nivel_id', 'grado', 'estado']; // Asegúrate de agregar 'estado' a los campos permitidos

    public function obtenerCursos()
    {
        $idrol = session()->get('idrol');
        $user_id = session()->get('iduser');
        
        if ($idrol === '1') {
            return $this->getCursosAndAsignaturas($user_id);
        } elseif ($idrol === '2' || $idrol === '3') {
            return $this->getAllCursosAndAsignaturas();
        }
        
        return [];
    }

    public function getCursosByTeacher($user_id)
    {
        return $this->select('cursos.*, usuarios.nombre AS nombre_usuario, nivel.nombre AS nombre_nivel')
                    ->join('usuarios', 'usuarios.user_id = cursos.user_id')
                    ->join('nivel', 'nivel.nivel_id = cursos.nivel_id')
                    ->where('cursos.user_id', $user_id)
                    ->where('estado !=', '')  // Filtramos los cursos activos
                    ->where('estado IS NOT NULL')  // Aseguramos que el estado no sea NULL
                    ->distinct()
                    ->findAll();
    }

    public function getCursosAndAsignaturas($user_id)
    {
        $cursos_directos = $this->select('cursos.*, usuarios.nombre AS nombre_usuario, nivel.nombre AS nombre_nivel')
                                ->join('usuarios', 'usuarios.user_id = cursos.user_id')
                                ->join('nivel', 'nivel.nivel_id = cursos.nivel_id')
                                ->where('cursos.user_id', $user_id)
                                ->where('estado !=', '')  // Filtramos los cursos activos
                                ->where('estado IS NOT NULL')  // Aseguramos que el estado no sea NULL
                                ->findAll();

        $asignatura_ids = $this->db->table('asignaturas')
                                   ->select('asignatura_id')
                                   ->where('user_id', $user_id)
                                   ->get()
                                   ->getResultArray();
        
        if (!empty($asignatura_ids)) {
            $cursos_asignaturas = $this->db->table('cursos_asignaturas')
                                           ->select('curso_id')
                                           ->whereIn('asignatura_id', array_column($asignatura_ids, 'asignatura_id'))
                                           ->get()
                                           ->getResultArray();
            
            if (!empty($cursos_asignaturas)) {
                $cursos_por_asignaturas = $this->select('cursos.*, usuarios.nombre AS nombre_usuario, nivel.nombre AS nombre_nivel')
                                               ->join('usuarios', 'usuarios.user_id = cursos.user_id')
                                               ->join('nivel', 'nivel.nivel_id = cursos.nivel_id')
                                               ->whereIn('cursos.curso_id', array_column($cursos_asignaturas, 'curso_id'))
                                               ->where('estado !=', '')  // Filtramos los cursos activos
                                               ->where('estado IS NOT NULL')  // Aseguramos que el estado no sea NULL
                                               ->findAll();
                
                $todos_los_cursos = array_merge($cursos_directos, $cursos_por_asignaturas);
                $todos_los_cursos = array_unique($todos_los_cursos, SORT_REGULAR);

                return $todos_los_cursos;
            }
        }

        return $cursos_directos;
    }

    public function getAllCursosAndAsignaturas()
    {
        return $this->select('cursos.*, usuarios.nombre AS nombre_usuario, nivel.nombre AS nombre_nivel')
                    ->join('usuarios', 'usuarios.user_id = cursos.user_id')
                    ->join('nivel', 'nivel.nivel_id = cursos.nivel_id')
                      // Filtramos los cursos activos
                    ->where('estado IS NULL')  // Aseguramos que el estado no sea NULL
                    ->findAll();
    }

    public function getAsignaturasPorCurso($cursoId)
    {
        $user_id = session()->get('iduser');
    $idrol = session()->get('idrol');

    $isUserRelatedToCourse = $this->db->table('cursos')
                                       ->where('curso_id', $cursoId)
                                       ->where('user_id', $user_id)
                                       ->countAllResults() > 0;

    $query = $this->db->table('cursos_asignaturas')
                      ->join('asignaturas', 'asignaturas.asignatura_id = cursos_asignaturas.asignatura_id')
                      ->join('usuarios', 'usuarios.user_id = asignaturas.user_id') 
                      ->where('cursos_asignaturas.curso_id', $cursoId);

    if ($isUserRelatedToCourse || $idrol === '2' || $idrol === '3') {
        
        $query->select('cursos_asignaturas.curso_id, asignaturas.*, usuarios.nombre AS nombre')
              ->groupBy('asignaturas.asignatura_id');
    } else {
        $query->select('cursos_asignaturas.curso_id, asignaturas.*, usuarios.nombre AS nombre')
              ->where('asignaturas.user_id', $user_id);
    }

    return $query->get()->getResultArray();
    }

    public function obtenerCursoPorId($id)
    {
        return $this->find($id);
    }

    public function crearCurso($data)
    {
        return $this->insert($data);
    }

    public function actualizarCurso($cursoid, $data)
    {
        return $this->update($cursoid, $data);
    }

    public function eliminarCurso($id)
    {
        // Borrado lógico: se actualiza el campo estado a vacío
        return $this->update($id, ['estado' => '']); 
    }

    public function getAsistenciasCurso($cursoId) {
        $builder = $this->db->table('asistencia');
        
        return $builder->select('a.asistencia_id, a.estudiante_id, e.nombre_estudiante, a.fecha, a.presente')
                       ->join('estudiantes e', 'a.estudiante_id = e.estudiante_id', 'left')
                       ->where('a.curso_id', $cursoId)
                       ->orderBy('e.nombre_estudiante', 'ASC')
                       ->get()
                       ->getResultArray();
    }

    public function getCalificacionesCurso($cursoId) {
        $builder = $this->db->table('calificaciones');
        
        return $builder->select('c.calificacion_id, c.estudiante_id, e.nombre_estudiante, c.curso_id, c.nota, c.fecha_ingreso, 
                                ev.descripcion AS descripcion_evaluacion, asg.nombre_asignatura')
                       ->join('estudiantes e', 'e.estudiante_id = c.estudiante_id', 'left')
                       ->join('asignaturas asg', 'asg.asignatura_id = c.asignatura_id', 'left')
                       ->join('evaluaciones ev', 'ev.evaluacion_id = c.evaluacion_id', 'left')
                       ->where('c.curso_id', $cursoId)
                       ->orderBy('e.nombre_estudiante', 'ASC')
                       ->get()
                       ->getResultArray();
    }

    public function getAnotacionesCurso($cursoId) {
        $builder = $this->db->table('anotaciones');
        
        return $builder->select('a.anotacion_id, a.estudiante_id, e.nombre_estudiante, a.origen_anot, a.glosa_anot, a.fecha_anotacion')
                       ->join('estudiantes e', 'e.estudiante_id = a.estudiante_id', 'left')
                       ->where('a.curso_id', $cursoId)
                       ->orderBy('e.nombre_estudiante', 'ASC')
                       ->get()
                       ->getResultArray();
    }
}
