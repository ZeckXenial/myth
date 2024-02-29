<?php

namespace App\Controllers;

use App\Models\CalificacionesModel;
use App\Models\CursoModel;
use App\Models\EstudiantesModel;
use CodeIgniter\Controller;


class Calificaciones extends Controller
{
    private $CalificacionesModel;

    private $EstudiantesModel;
    private $cursoModel;

    public function __construct()
    {   
        $this->EstudiantesModel= new EstudiantesModel();
        $this->CalificacionesModel = new CalificacionesModel();
        $this->cursoModel = new CursoModel(); 
    }

    public function asignaturas($cursoId)
    {
        $asignaturas = $this->cursoModel->getAsignaturasPorCurso($cursoId);


        return view('components/asignaturas', ['asignaturas' => $asignaturas],['cursoid' => $cursoId]);
    }
    public function index($cursoId)
    {
        $curso = $this->cursoModel->find($cursoId);

        if (!$curso) {
            return redirect()->to(site_url('cursos'))->with('error', 'Curso no encontrado');
        }

        $calificaciones = $this->CalificacionesModel->getCalificacionesPorCurso($cursoId);

        $data = [
            'curso' => $curso,
            'calificaciones' => $calificaciones
        ];

        return view('components/calificaciones_curso', $data);
    }

    public function Calificaciones($asignatura_id,$curso_id)
    {
        $asignatura_id = $this->request->uri->getSegment(3);
        session()->set('asignatura_id', $asignatura_id);
        $curso_id = $this->request->uri->getSegment(2);

    $calificaciones = $this->CalificacionesModel->getCalificacionesPorasignatura($asignatura_id);
    $estudiantes = $this->EstudiantesModel->obtenerEstudiantesPorCurso($curso_id);

    return view('components/calificaciones_curso', ['calificaciones' => $calificaciones, 'estudiantes' => $estudiantes]);
    }

    public function guardar()
    {
        if ($this->request->isAJAX()) {
            $jsonData = $this->request->getPost('data');
            $calificaciones = json_decode($jsonData, true);
            $cursoId = $this->request->getPost('curso_id');
            $asignaturaId = $this->request->getPost('asignatura_id');
            
            try {
                foreach ($calificaciones as $calificacion) {
                    $idEstudiante = $calificacion['id_estudiante']; 
                    $nota = explode(',', $calificacion['nota']); 
                    $calificacionId = $calificacion['calificacion_id']; 
    
                    if ($calificacionId) {
                        // Actualizar la calificación existente
                        $this->CalificacionesModel->actualizarCalificacion($calificacionId, $nota);
                    } else {
                        // Insertar una nueva calificación
                        $this->CalificacionesModel->guardarCalificacion($idEstudiante, $nota, $cursoId, $asignaturaId);
                    }
                }
                
                return $this->response->setJSON(['success' => true, 'message' => 'Calificaciones guardadas correctamente']);
            } catch (\Exception $e) {
                log_message('error', 'Error al guardar calificaciones: ' . $e->getMessage());
                return $this->response->setJSON(['success' => false, 'message' => 'Error al guardar calificaciones']);
            }
        } else {
            return $this->response->setStatusCode(400)->setJSON(['success' => false, 'message' => 'Solicitud no válida']);
        }
    }
    public function editar($id)
    {
        $data['calificacion'] = $this->CalificacionesModel->find($id);

        return view('calificaciones/editar', $data);
    }

    public function update($id)
    {
        if ($this->request->getMethod() === 'post') {
            $data = [
                'estudiante_id' => $this->request->getPost('estudiante_id'),
                'curso_id' => $this->request->getPost('curso_id'),
                'asignatura_id' => $this->request->getPost('asignatura_id'),
                'nota' => $this->request->getPost('nota')
            ];

            $this->CalificacionesModel->update($id, $data);

            return redirect()->to(site_url('calificaciones'))->with('success', 'Calificación actualizada exitosamente');
        }
    }

    public function delete($id)
    {
        $this->CalificacionesModel->delete($id);

        return redirect()->to(site_url('calificaciones'))->with('success', 'Calificación eliminada exitosamente');
    }
}
