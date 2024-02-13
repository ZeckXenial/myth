<?php

namespace App\Controllers;

use App\Models\EstudiantesModel;
use App\Models\anotacionesmodel;
use CodeIgniter\Controller;

class Anotaciones extends Controller
{
    public function curso($curso_id)
    {
        $estudiantesModel = new EstudiantesModel();

        $estudiantes = $estudiantesModel->obtenerEstudiantesPorCurso($curso_id);

        if ($estudiantes) {
            return view('components/anotaciones_curso', ['estudiantes' => $estudiantes]);
        } else {
            
            return "No se encontraron estudiantes para este curso";
        }
    }
}
