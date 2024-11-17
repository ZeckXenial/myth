<?php

namespace App\Controllers;

use App\Models\AnotacionesModel;
use App\Models\EstudiantesModel;

use CodeIgniter\Controller;

class Anotaciones extends Controller
{
    public function curso($curso_id)
    {
        $estudiantesModel = new EstudiantesModel();
        $anotacionesModel = new AnotacionesModel();
        
        $estudiantes = $estudiantesModel->obtenerEstudiantesPorCurso($curso_id);

        foreach ($estudiantes as &$estudiante) {
            $estudiante['anotaciones'] = $anotacionesModel->obtenerAnotacionesPorEstudiante($estudiante['estudiante_id']);
        }

        if ($estudiantes) {
            return view('components/anotaciones_curso', ['estudiantes' => $estudiantes]);
        } else {
            return view('components/error');
        }
    }
    public function crear()
    {
        $request = service('request');

        $anotacionesModel = new AnotacionesModel();
        $fecha_anotacion = $fecha ?? date('Y-m-d'); 
        $data = [
            'estudiante_id' => $request->getPost('estudiante_id'),
            'user_id' => $request->getPost('user_id'),
            'fecha_anotacion' => $request->getPost('fecha_anotacion'),
            'grado' => $request->getPost('grado'),
            'curso_id' => $request->getPost('curso_id'),
            'origen_anot' => $request->getPost('origen_anotacion'),
            'glosa_anot' => $request->getPost('glosa')
        ];
    
        $anotacionesModel->crearAnotacion($data);

        return redirect()->back()->with('success', 'Anotación creada exitosamente');
    }

    public function editar($anotacion_id)
    {
        $request = service('request');

        $anotacionesModel = new AnotacionesModel();

        $data = [
            'estudiante_id' => $request->getPost('estudiante_id'),
            'user_id' => $request->getPost('user_id'),
            'origen_anot' => $request->getPost('origen_anotacion'),
            'glosa_anot' => $request->getPost('glosa')
        ];

        $anotacionesModel->editarAnotacion($anotacion_id, $data);

        return redirect()->back()->with('success', 'Anotación editada exitosamente');
    }

    public function eliminar($anotacion_id)
    {
        $anotacionesModel = new AnotacionesModel();
        $anotacionesModel->eliminarAnotacion($anotacion_id);

        return redirect()->back()->with('success', 'Anotación eliminada exitosamente');
    }
}
