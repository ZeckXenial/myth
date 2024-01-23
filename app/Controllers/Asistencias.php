<?php
namespace App\Controllers;

use App\Models\AsistenciasModel;

class Asistencias extends BaseController
{
    private $asistenciasModel;

    public function __construct()
    {
        $this->asistenciasModel = new AsistenciasModel();
    }

    public function curso($cursoId)
    {
        $data['asistencias'] = $this->asistenciasModel->getAsistenciasPorCurso($cursoId);
        return view('components/asistencia_curso', $data);
    }
}
