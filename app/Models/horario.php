<?php

namespace App\Models;

use CodeIgniter\Model;

class horario extends Model
{
    protected $table = 'horarios_clases';
    protected $primaryKey = 'horario_id';
    protected $allowedFields = ['profesor_id', 'recurrencia' ,'curso_id', 'asignatura_id', 'asignaturas.nombre' ,'dia_semana', 'hora_inicio', 'hora_fin', 'anio_escolar'];

    public function insertarHorario($profesor_id, $curso_id, $recurrencia ,$asignatura_id, $dia_semana, $hora_inicio, $hora_fin) {
        if ($this->verificarConflicto($profesor_id, $asignatura_id, $dia_semana, $hora_inicio, $hora_fin, $horario_id)) {
            throw new \Exception("Conflicto de horarios.");
        }
        $data = [
            'profesor_id' => $profesor_id,
            'curso_id' => $curso_id, // Asegúrate de que este campo esté presente
            'asignatura_id' => $asignatura_id,
            'dia_semana' => $dia_semana,
            'hora_inicio' => $hora_inicio,
            'recurrencia' => $recurrencia,
            'hora_fin' => $hora_fin,
            'anio_escolar' => date('Y') // Obtener el año actual
        ];
        
        return $this->insert($data);
    }

    public function editarHorario($horario_id,$dia_semana, $hora_inicio, $hora_fin) {
        $horario = $this->find($horario_id);
        if (!$horario) {
            throw new \Exception("Horario no encontrado.");
        }

        $profesor_id = $horario['profesor_id'];
        $asignatura_id = $horario['asignatura_id'];

        // Validar horarios
        if ($this->verificarConflicto($profesor_id, $asignatura_id, $dia_semana, $hora_inicio, $hora_fin, $horario_id)) {
            throw new \Exception("Conflicto de horarios.");
        }

        return $this->update($horario_id, [
            'dia_semana' => $dia_semana,
            'hora_inicio' => $hora_inicio,
            'hora_fin' => $hora_fin,
            'anio_escolar' => date('Y') // Obtener el año actual

        ]);
    }

    public function eliminarHorario($horario_id) {
        return $this->delete($horario_id);
    }

    public function verificarConflicto($profesor_id, $asignatura_id, $dia_semana, $hora_inicio, $hora_fin, $horario_id = null) {
        $this->where('profesor_id', $profesor_id)
             ->where('asignatura_id', $asignatura_id)
             ->where('dia_semana', $dia_semana)
             ->groupStart()
                ->where('hora_inicio <', $hora_fin)
                ->where('hora_fin >', $hora_inicio)
             ->groupEnd();

        if ($horario_id) {
            $this->where('horario_id !=', $horario_id);
        }

        return $this->countAllResults() > 0;
    }

    public function consultarHorarios($profesor_id) {
        return $this->where('profesor_id', $profesor_id)->findAll();
    }
    public function getHorariosPorCurso($curso_id) {
        $db = \Config\Database::connect();
        $query = $db->table('horarios_clases')
            ->select('horarios_clases.horario_id, asignaturas.nombre_asignatura AS asignatura_nombre, cursos.nombre AS curso_nombre, dia_semana, hora_inicio, hora_fin')
            ->join('asignaturas', 'asignaturas.asignatura_id = horarios_clases.asignatura_id')
            ->join('cursos', 'cursos.curso_id = horarios_clases.curso_id')
            ->where('horarios_clases.curso_id', $curso_id)
            ->get();
    
        $eventos = [];
        foreach ($query->getResultArray() as $horario) {
            $eventos[] = [
                'id'    => $horario['horario_id'],
                'title' => $horario['asignatura_nombre'], // Nombre en lugar de ID
                'start' => date('Y-m-d') . 'T' . $horario['hora_inicio'], // Formato compatible
                'end'   => date('Y-m-d') . 'T' . $horario['hora_fin'],
                'description' => 'Curso: ' . $horario['curso_nombre'] . ', Día: ' . $horario['dia_semana']
            ];
        }
    
        return $this->response->setJSON($eventos);
    }
    
}