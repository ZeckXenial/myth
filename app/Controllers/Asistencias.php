<?php
namespace App\Controllers;

use App\Models\AsistenciasModel;
use App\Models\EstudiantesModel;


class Asistencias extends BaseController
{
    private $asistenciasModel;

    public function __construct()
    {
        $this->asistenciasModel = new EstudiantesModel();
    }

    public function curso($cursoId)
    {
        $data['asistencias'] = $this->asistenciasModel->obtenerEstudiantesPorCurso($cursoId);
        return view('components/asistencias', $data);
    }
    public function ingresarAsistencias()
    {
        // Verificar si la solicitud es de tipo POST
        if ($this->request->getMethod() === 'post') {
            $asistencias = $this->request->getPost();
    
            $model = new AsistenciasModel();
    
            foreach ($asistencias as $estudiante_id => $asistencia) {
                // Verificar si $asistencia es un array
                if (is_array($asistencia)) {
                    $presente = ($asistencia['asistencia'] == 'on') ? 1 : 0;
    
                    $data = [
                        'estudiante_id' => $estudiante_id,
                        'presente' => $presente,
                        'fecha_asistencia' => date('Y-m-d H:i:s') 
                    ];
    
                    $model->ingresarAsistencias($data);
                }
            }
    
            return redirect()->to(site_url('components/asistencias'))->with('success', 'Asistencias guardadas exitosamente');
        } else {
            return redirect()->to(site_url('components/asistencias'))->with('error', 'Error al procesar la solicitud');
        }
    }
    
}
