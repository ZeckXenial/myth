<?php

namespace App\Controllers;

use App\Models\EstudiantesModel;
use App\Models\EvaluacionesModel;
use App\Models\CalificacionesModel;
use App\Models\CursoModel;

class Calificaciones extends BaseController
{
    private $estudiantesModel;
    private $evaluacionesModel;
    private $calificacionesModel;
    private $cursoModel;

    public function __construct()
    {
        $this->estudiantesModel = new EstudiantesModel();
        $this->evaluacionesModel = new EvaluacionesModel();
        $this->calificacionesModel = new CalificacionesModel();
        $this->cursoModel = new CursoModel();
    }

    public function calificaciones($asignaturaId,$cursoId)
    {

        session()->set('asignatura_id', $asignaturaId);

        // Obtener los estudiantes para el curso
        $estudiantes = $this->estudiantesModel->obtenerEstudiantesPorCurso($asignaturaId);
        
        // Obtener las evaluaciones de la asignatura
        $evaluaciones = $this->evaluacionesModel->obtenerEvaluacionesPorCursoYAsignatura($asignaturaId,$cursoId);
        $parametrostabla = [$asignaturaId,$cursoId];
        // Obtener las calificaciones de los estudiantes para las evaluaciones
        $calificaciones = $this->calificacionesModel->obtenerCalificacionesPorFecha($cursoId,$asignaturaId);
        // Pasar los datos a la vista
        
        return view('components/calificaciones_curso', [
            'estudiantes' => $estudiantes,
            'evaluaciones' => $evaluaciones,
            'calificaciones' => $calificaciones,
            'parametrostable' => $parametrostabla,
        ]);
    }
    // CalificacionesController.php

    public function obtenerCalificaciones($asignaturaId, $cursoId)
{
    // Obtén evaluaciones específicas del curso y asignatura
    $evaluaciones = $this->evaluacionesModel->obtenerEvaluaciones($cursoId, $asignaturaId);
    
    // Obtén estudiantes del curso específico
    $estudiantes = $this->estudiantesModel->obtenerEstudiantesPorCurso($cursoId);
    
    // Obtén las calificaciones por fecha para la asignatura y curso solicitados
    $calificaciones = $this->calificacionesModel->obtenerCalificacionesPorFecha($cursoId, $asignaturaId);

    $response = [
        'evaluaciones' => $evaluaciones,
        'estudiantes' => $estudiantes,
        'calificaciones' => $calificaciones
    ];
    
    return $this->response->setJSON($response);
}

    public function asignaturas($cursoId)
    {
        $asignaturas = $this->cursoModel->getAsignaturasPorCurso($cursoId);


        return view('components/asignaturas', ['asignaturas' => $asignaturas],['cursoid' => $cursoId]);
    }
    public function agregarEvaluacion()
    {
        $numeroEvaluacion = $this->request->getPost('numero_evaluacion');
        $fechaEvaluacion = $this->request->getPost('fecha_evaluacion');
        $descripcion = $this->request->getPost('descripcion');
        $semestre = $this->request->getPost('semestre');
        $asignaturaId = $this->request->getPost('asignatura_id');
        $cursoId = $this->request->getPost('curso_id');

        $data = [
            'numero_evaluacion' => $numeroEvaluacion,
            'fecha_evaluacion' => $fechaEvaluacion,
            'descripcion' => $descripcion,
            'semestre' => $semestre,
            'asignatura_id' => $asignaturaId,
            'curso_id' => $cursoId
        ];
    
        // Guardar la evaluación
        $evaluacionId = $this->evaluacionesModel->guardarEvaluacion($data);

        // Verificar si la evaluación se guardó correctamente
        if ($evaluacionId) {
            // Mensaje de éxito y recarga de la página
            return redirect()->back()->with('success', 'Se guardó correctamente');
        } else {
            // Mensaje de error y recarga de la página
            return redirect()->back()->with('error', 'Hubo un error al guardar');
        }
    }

    public function guardarnota()
    {
        // Obtener datos del frontend
        $estudianteId = $this->request->getGet('estudiante_id');  // Estudiante
        $evaluacionId = $this->request->getGet('evaluacion_id');  // Evaluación
        $nota = $this->request->getGet('nota');  // Nota ingresada
        $userId = session()->get('iduser');  // Obtener el user_id de la sesión (autenticación)
    
        // Validación: si la nota está vacía, se guarda como 0
        $nota = trim($nota);
        $nota = empty($nota) ? 0 : $nota;
    
        // Buscar los detalles de la evaluación para obtener el asignatura_id
        $evaluacion = $this->evaluacionesModel->find($evaluacionId);
        $cursoId = $evaluacion['curso_id'][0];
        $asignaturaId = $evaluacion['asignatura_id'][0];  // Asignatura relacionada con la evaluación
    
        // Buscar si ya existe una calificación para este estudiante y evaluación
        $calificacion = $this->calificacionesModel->buscarCalificacion($estudianteId, $evaluacionId);
    
        // Si no existe, se inserta una nueva calificación
        if (!$calificacion) {
            $data = [
                'estudiante_id' => $estudianteId,
                'evaluacion_id' => $evaluacionId,
                'asignatura_id' => $asignaturaId,
                'user_id' => $userId,
                'curso_id' => $cursoId,
                'nota' => $nota
            ];
            
            $resultado = $this->calificacionesModel->insertCalificacion($data);
        } else {
            // Si ya existe, se actualiza la calificación
            $data = [
                'nota' => $nota
            ];
            $resultado = $this->calificacionesModel->actualizarCalificacion($calificacion['calificacion_id'], $data);
        }
    
        // Verificar si la operación fue exitosa
        if ($resultado) {
            session()->setFlashdata('message', 'Calificación guardada correctamente.');
            session()->setFlashdata('status', 'success');
        } else {
            session()->setFlashdata('message', 'Hubo un error al guardar la calificación.');
            session()->setFlashdata('status', 'error');
        }
    
        // Redirigir de vuelta a la vista de calificaciones (ajusta la ruta según sea necesario)
        return redirect()->to('calificaciones/'. $cursoId .'/'.  $asignaturaId);
    }
    
    
}
