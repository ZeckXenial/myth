<?php

namespace App\Controllers;

use App\Models\CursoModel;
use App\Models\CrudUsuarioModel;
use App\Models\AsignaturaModel;
use App\Models\AsignaturacursoModel;
use App\Models\NivelModel;
use CodeIgniter\Controller;

class Cursos extends Controller
{
    private $cursoModel;
    private $nivelModel;
    private $asignaturaModel;
    private $asignaturacursoModel;
    private $crudUsuarioModel;

    public function __construct()
    {
        $this->cursoModel = new CursoModel();
        $this->nivelModel = new NivelModel();
        $this->asignaturaModel = new AsignaturaModel();
        $this->asignaturacursoModel = new AsignaturacursoModel();
        $this->crudUsuarioModel = new CrudUsuarioModel();
    }

    public function index()
    {
        $data['cursos'] = $this->cursoModel->findAll();
        return view('cursos/index', $data);
    }

    public function editar($id)
    {
        $data['curso'] = $this->cursoModel->obtenerCursoPorId($id);
        $data['asignaturas'] = $this->asignaturaModel->obtenerAsignaturas();
        $data['usuarios'] = $this->crudUsuarioModel->findAll();
        $data['niveles'] = $this->nivelModel->obtenerNiveles();

        return view('components/edit', $data);
    }
    public function guardar()
{
    if ($this->request->getMethod() === 'post') {
        // Obtener los valores del formulario
        $user_id = $this->request->getPost('user_id');
        $grado = $this->request->getPost('grado');
        $nivel_id = $this->request->getPost('nivel_id');
        $asignatura_ids = $this->request->getPost('asignatura_id'); // Este será un array

        // Crear un nuevo curso
        $cursoModel = new CursoModel();
        $curso_id = $cursoModel->insert(['user_id' => $user_id, 'grado' => $grado, 'nivel_id' => $nivel_id]);

        // Verificar si el curso se creó correctamente
        if ($curso_id) {
            // Insertar los registros en la tabla asignatura_curso
            foreach ($asignatura_ids as $asignatura_id) {
                $asignaturaCursoModel = new AsignaturaCursoModel();
                $asignaturaCursoModel->insert(['curso_id' => $curso_id, 'asignatura_id' => $asignatura_id]);
            }

            return redirect()->to(site_url('cursos'))->with('success', 'Curso agregado exitosamente');
        } else {
            return redirect()->to(site_url('cursos'))->with('error', 'Error al agregar el curso');
        }
    }

    return redirect()->to(site_url('cursos'))->with('error', 'Error al procesar la solicitud');
}
    public function agregar()
{
    $nivelModel = new NivelModel();
    $asignaturaModel = new AsignaturaModel();
    $usuarioModel = new CrudUsuarioModel();

    $data['niveles'] = $nivelModel->findAll();
    $data['asignaturas'] = $asignaturaModel->findAll();
    $data['usuarios'] = $usuarioModel->findAll();

    return view('components/agregar', $data);
}
    public function update($cursoId)
    {
        if ($this->request->getMethod() === 'post') {
            $data = [
                'grado' => $this->request->getPost('grado'),
                'asignatura_id' => $this->request->getPost('asignatura_id'),
                'user_id' => $this->request->getPost('user_id'),
                'nivel_id' => $this->request->getPost('nivel_id'),
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
        $this->cursoModel->eliminarCurso($id);
        return redirect()->to('/cursos');
    }
}
