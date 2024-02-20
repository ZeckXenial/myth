<?php

namespace App\Controllers;

use App\Models\CalificacionesModel;
use App\Models\CursoModel;
use CodeIgniter\Controller;

class Calificaciones extends Controller
{
    private $CalificacionesModel;
    private $cursoModel;

    public function __construct()
    {
        $this->CalificacionesModel = new CalificacionesModel();
        $this->cursoModel = new CursoModel(); 
    }

    public function asignaturas($cursoId)
    {
        $asignaturas = $this->cursoModel->getAsignaturasPorCurso($cursoId);


        return view('components/asignaturas', ['asignaturas' => $asignaturas]);
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

        return view('components/asignaturas', $data);
    }

    public function Calificaciones()
    {
        // Obtener todas las calificaciones
        $data['calificaciones'] = $this->CalificacionesModel->findAll();

        // Cargar la vista con las calificaciones
        return view('components/calificaciones', $data);
    }

    public function guardar()
    {
        if ($this->request->getMethod() === 'post') {
            $data = [
                'estudiante_id' => $this->request->getPost('estudiante_id'),
                'curso_id' => $this->request->getPost('curso_id'),
                'asignatura_id' => $this->request->getPost('asignatura_id'),
                'nota' => $this->request->getPost('nota')
            ];

            $this->CalificacionesModel->insert($data);

            return redirect()->to(site_url('calificaciones'))->with('success', 'Calificación agregada exitosamente');
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
