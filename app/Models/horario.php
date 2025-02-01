<?php

namespace App\Models;

use CodeIgniter\Model;

class horario extends Model
{
    protected $table = 'horarios_clases';
    protected $primaryKey = 'horario_id';
    protected $allowedFields = ['profesor_id','curso_id', 'asignatura_id', 'dia_semana', 'hora_inicio', 'hora_fin', 'anio_escolar'];

    public function insertarHorario($profesor_id, $curso_id, $asignatura_id, $dia_semana, $hora_inicio, $hora_fin) {
        $data = [
            'profesor_id' => $profesor_id,
            'curso_id' => $curso_id, // Asegúrate de que este campo esté presente
            'asignatura_id' => $asignatura_id,
            'dia_semana' => $dia_semana,
            'hora_inicio' => $hora_inicio,
            'hora_fin' => $hora_fin,
            'anio_escolar' => date('Y') // Obtener el año actual
        ];
        return $this->insert($data);
    }

    public function editarHorario($horario_id, $profesor_id, $asignatura_id, $dia_semana, $hora_inicio, $hora_fin, $anio_escolar) {
        // Validar horarios
        if ($this->verificarConflicto($profesor_id, $asignatura_id, $dia_semana, $hora_inicio, $hora_fin, $horario_id)) {
            throw new \Exception("Conflicto de horarios.");
        }

        return $this->update($horario_id, [
            'profesor_id' => $profesor_id,
            'asignatura_id' => $asignatura_id,
            'dia_semana' => $dia_semana,
            'hora_inicio' => $hora_inicio,
            'hora_fin' => $hora_fin,
            'anio_escolar' => $anio_escolar
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
}