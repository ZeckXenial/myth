<?php

namespace App\Models;

use CodeIgniter\Model;

class CursoModel extends Model
{
    protected $table      = 'cursos';
    protected $primaryKey = 'curso_id';
    protected $allowedFields = ['user_id', 'asignatura_id', 'nivel_id', 'grado'];

    public function obtenerCursos()
    {
        $user_id = session()->get('user_id');

        if (session()->get('idrol') === '1') {
            return $this->getCursosByTeacher($user_id);
        } elseif (session()->get('idrol') === '2' || session()->get('idrol') === '3') {
            return $this->getCursosByDirective();
        }

        return [];
    }

    public function getAsignaturasPorCurso($cursoId)
    {
        return $this->db->table('cursos_asignaturas')
            ->join('asignaturas', 'asignaturas.asignatura_id = cursos_asignaturas.asignatura_id')
            ->where('cursos_asignaturas.curso_id', $cursoId)
            ->get()->getResultArray();
    }

    public function getCursosByTeacher($user_id)
    {
        return $this->select('cursos.*, usuarios.nombre AS nombre_usuario, nivel.nombre AS nombre_nivel')
            ->join('usuarios', 'usuarios.user_id = cursos.user_id')
            ->join('nivel', 'nivel.nivel_id = cursos.nivel_id')
            ->where('cursos.user_id', $user_id)
            ->findAll();
    }

    public function getCursosByDirective()
    {
        return $this->select('cursos.*, usuarios.nombre AS nombre_usuario, nivel.nombre AS nombre_nivel')
            ->join('usuarios', 'usuarios.user_id = cursos.user_id')
            ->join('nivel', 'nivel.nivel_id = cursos.nivel_id', 'left')
            ->findAll();
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
        return $this->delete(['curso_id' => $id]); // Eliminar el curso por ID
    }
}