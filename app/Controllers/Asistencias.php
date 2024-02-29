<?php

namespace App\Controllers;

use App\Models\AsistenciasModel;
use App\Models\EstudiantesModel;

class Asistencias extends BaseController
{
    private $estudiantesModel;

    public function __construct()
    {
        $this->estudiantesModel = new EstudiantesModel();
    }

    public function curso($cursoId)
    {   $data['cursoId'] = $cursoId;
        $data['asistencias'] = $this->estudiantesModel->obtenerEstudiantesPorCurso($cursoId);
        return view('components/asistencias', $data);
    }

    public function ingresarAsistencias($cursoId)
{
    if ($this->request->getMethod() === 'post') {
        $asistencias = $this->request->getPost('asistencias');

        if (!empty($asistencias)) {
            $model = new AsistenciasModel();
            $fecha_asistencia = date('Y-m-d'); 

            foreach ($_POST['asistencias'] as $asistencia) {
                $data = [
                    'estudiante_id' => $asistencia['estudiante_id'],
                    'presente' => isset($asistencia['presente']) ? 1 : 0,
                    'fecha' => $fecha_asistencia
                ];
            
                $model->ingresarAsistencias($data);
            }

            return redirect()->to(site_url("cursos"))->with('success', 'Asistencias guardadas exitosamente');
        } else {
            return redirect()->to(site_url("asistencias/curso/$cursoId"))->with('error', 'No se recibieron datos de asistencia');
        }
    } else {
        return redirect()->to(site_url("asistencias/curso/$cursoId"))->with('error', 'Error al procesar la solicitud');
    }
}
}
