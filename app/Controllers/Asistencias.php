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
    // Verificar si la solicitud es de tipo POST
    if ($this->request->getMethod() === 'post') {
        $asistencias = $this->request->getPost('asistencias');

        if (!empty($asistencias)) {
            $model = new AsistenciasModel();

            foreach ($asistencias as $estudiante_id => $presente) {
                $data = [
                    'estudiante_id' => $estudiante_id,
                    'presente' => ($presente == 'presente') ? 1 : 0,
                    'fecha_asistencia' => date('Y-m-d H:i:s')
                ];

                $model->ingresarAsistencias($data);
            }

            // Redirigir a la vista de asistencias del curso con el ID del curso
            return redirect()->to(site_url("asistencias/curso/$cursoId"))->with('success', 'Asistencias guardadas exitosamente');
        } else {
            return redirect()->to(site_url("asistencias/curso/$cursoId"))->with('error', 'No se recibieron datos de asistencia');
        }
    } else {
        return redirect()->to(site_url("asistencias/curso/$cursoId"))->with('error', 'Error al procesar la solicitud');
    }
}
}
