<?php

namespace App\Controllers;

use App\Models\AsistenciasModel;
use App\Models\EstudiantesModel;

class Asistencias extends BaseController
{
    private $estudiantesModel;
    private $asistenciasModel;


    public function __construct()
    {
        $this->estudiantesModel = new EstudiantesModel();
        $this->asistenciasModel = new AsistenciasModel();

    }

    public function curso($cursoId)
    {
        $data['cursoId'] = $cursoId;
        $data['asistencias'] = $this->estudiantesModel->obtenerEstudiantesPorCurso($cursoId);
        $data['ultimaFechaAsistencia'] = $this->asistenciasModel->obtenerUltimaFechaAsistenciaPorCurso($cursoId);
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
                    'fecha' => $fecha_asistencia,
                    'curso_id' => $cursoId,
                    'presente' => isset($asistencia['presente']) ? 1 : 0,
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
