<?php

namespace App\Controllers;

use App\Models\asistenciasmodel;
use App\Models\estudiantesmodel;

class Asistencias extends BaseController
{
    private $estudiantesModel;
    private $asistenciasModel;


    public function __construct()
    {
        $this->estudiantesModel = new estudiantesmodel();
        $this->asistenciasModel = new asistenciasmodel();

    }

    public function curso($cursoId)
    {
        $fecha = $fecha ?? date('Y-m-d'); 

        $data['cursoId'] = $cursoId;
        $data['asistencias'] = $this->estudiantesModel->obtenerEstudiantesPorCurso($cursoId);
        $data['estudiantesPresentes'] = $this->asistenciasModel->getEstudiantesPresentes($cursoId,$fecha);
        $data['ultimaFechaAsistencia'] = $this->asistenciasModel->obtenerUltimaFechaAsistenciaPorCurso($cursoId);
        return view('Components/asistencias', $data);
    }
    

    public function ingresarAsistencias($cursoId)
{
    if ($this->request->getMethod() === 'post') {
        $asistencias = $this->request->getPost('asistencias');

        if (!empty($asistencias)) {
            $model = new AsistenciasModel();
            $fecha_asistencia = date('Y-m-d'); 

            foreach ($asistencias as $asistencia) {
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
