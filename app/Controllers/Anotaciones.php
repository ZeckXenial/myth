<?php

namespace App\Controllers;

use App\Models\anotacionesmodel;
use App\Models\estudiantesmodel;

use CodeIgniter\Controller;

class Anotaciones extends Controller
{
    public function curso($curso_id)
    {
        $estudiantesModel = new estudiantesmodel();
        $anotacionesModel = new anotacionesmodel();
        
        $estudiantes = $estudiantesModel->obtenerEstudiantesPorCurso($curso_id);

        foreach ($estudiantes as &$estudiante) {
            $estudiante['anotaciones'] = $anotacionesModel->obtenerAnotacionesPorEstudiante($estudiante['estudiante_id']);
        }

        if ($estudiantes) {
            return view('Components/anotaciones_curso', ['estudiantes' => $estudiantes]);
        } else {
            return view('Components/error');
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
    $data = $this->request->getPost(); // Obtener los datos del formulario

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