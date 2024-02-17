<?php

namespace App\Controllers;

use App\Models\CursoModel;
use App\Models\CrudUsuarioModel;
use App\Models\AsignaturaModel;
use App\Models\NivelModel;
use CodeIgniter\Controller;

class Cursos extends Controller
{
    private $cursoModel;

    public function __construct()
    {
        $this->cursoModel = new CursoModel();
        $this->nivelModel = new nivelModel();
        $this->asignaturaModel = new AsignaturaModel();
        $this->CrudUsuarioModel = new CrudUsuarioModel();
    }

    public function index()
    {
        $data['cursos'] = $this->cursoModel->findAll();
        return view('cursos/index', $data);
    }

    public function editar($id)
    {
        $cursoModel = new CursoModel();
        $asignaturaModel = new AsignaturaModel();
        $usuarioModel = new CrudUsuarioModel();
        $nivelModel = new NivelModel();

        $data['curso'] = $cursoModel->obtenerCursoPorId($id);
        $data['asignaturas'] = $asignaturaModel->obtenerAsignaturas();
        $data['usuarios'] = $usuarioModel->findAll();
        $data['niveles'] = $nivelModel->obtenerNiveles();

        return view('components/edit', $data);
    }

    public function update($cursoId)
    {
        // Verificar si la solicitud es de tipo POST
        if ($this->request->getMethod() === 'post') {
            $data = [
                'grado' => $this->request->getPost('grado'),
                'asignatura_id' => $this->request->getPost('asignatura_id')
            ];

            // Actualizar el curso
            if ($this->cursoModel->actualizarCurso($cursoId, $data)) {
                return redirect()->to(site_url('cursos'))->with('success', 'Curso actualizado exitosamente');
            } else {
                return redirect()->to(site_url('cursos'))->with('error', 'Error al actualizar el curso');
            }
        }

        return redirect()->to(site_url('cursos'))->with('error', 'Error al procesar la solicitud');
    }
    public function delete($id)
    {
        $this->cursoModel->delete($id);
        return redirect()->to('/cursos');
    }
}
