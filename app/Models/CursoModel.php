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
    // Cursos donde el usuario es responsable directo
    $cursos_directos = $this->select('cursos.*, usuarios.nombre AS nombre_usuario, nivel.nombre AS nombre_nivel')
                            ->join('usuarios', 'usuarios.user_id = cursos.user_id')
                            ->join('nivel', 'nivel.nivel_id = cursos.nivel_id')
                            ->where('cursos.user_id', $user_id)
                            ->where('estado IS NULL')
                            ->findAll();

    // Obtener las asignaturas del usuario
    $asignatura_ids = $this->db->table('asignaturas')
                               ->select('asignatura_id')
                               ->where('user_id', $user_id)
                               ->get()
                               ->getResultArray();

    // Si el usuario no tiene asignaturas, devolver cursos directos
    if (empty($asignatura_ids)) {
        return $cursos_directos;
    }

    // Obtener cursos asociados a las asignaturas del usuario
    $asignatura_ids = array_column($asignatura_ids, 'asignatura_id');
    $cursos_asignaturas = $this->db->table('cursos_asignaturas')
                                   ->select('curso_id')
                                   ->whereIn('asignatura_id', $asignatura_ids)
                                   ->get()
                                   ->getResultArray();

    // Si no hay cursos relacionados con las asignaturas, devolver cursos directos
    if (empty($cursos_asignaturas)) {
        return $cursos_directos;
    }

    $cursos_por_asignaturas = $this->select('cursos.*, usuarios.nombre AS nombre_usuario, nivel.nombre AS nombre_nivel')
                                   ->join('usuarios', 'usuarios.user_id = cursos.user_id')
                                   ->join('nivel', 'nivel.nivel_id = cursos.nivel_id')
                                   ->whereIn('cursos.curso_id', array_column($cursos_asignaturas, 'curso_id'))
                                   ->where('estado IS  NULL')
                                   ->findAll();

    // Fusionar y eliminar duplicados
    $todos_los_cursos = array_merge($cursos_directos, $cursos_por_asignaturas);
    $todos_los_cursos = array_map("unserialize", array_unique(array_map("serialize", $todos_los_cursos)));

    return $todos_los_cursos;
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
        
        // Realiza la consulta con select, where y obtiene los resultados
        return $builder->select('fecha, presente')
                       ->where('curso_id', $cursoId)
                       ->get()
                       ->getResultArray();  // Devuelve los resultados en un array
    }
    
    public function getCalificacionesCurso($cursoId) {
        $builder = $this->db->table('calificaciones');
    
        // Realiza la consulta con el JOIN a la tabla 'asignaturas' y selecciona 'nombre_asignatura'
        return $builder->select('asignaturas.nombre_asignatura, calificaciones.nota')
                       ->join('asignaturas', 'asignaturas.asignatura_id = calificaciones.asignatura_id', 'left') // Realiza el JOIN con la tabla 'asignaturas'
                       ->where('calificaciones.curso_id', $cursoId) // Filtro para el curso
                       ->get() // Ejecuta la consulta
                       ->getResultArray();  // Devuelve los resultados como un array
    }
    
    public function getAnotacionesCurso($cursoId) {
        $builder = $this->db->table('anotaciones');
        
        // Realiza la consulta con select, where y obtiene los resultados
        return $builder->select('origen_anot, glosa_anot')
                       ->where('curso_id', $cursoId)
                       ->get()
                       ->getResultArray();  // Devuelve los resultados en un array
    }
    
}
