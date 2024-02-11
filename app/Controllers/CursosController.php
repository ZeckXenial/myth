<?php

namespace App\Controllers;

use App\Models\CursoModel;

class CursosController extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }
public function index()
{
    $cursosModel = new CursoModel();
    $data['cursos'] = $this->obtenerCursosSegunRol($cursosModel);
    return view('components/cursos', $data);
}

private function obtenerCursosSegunRol($cursosModel)
{
    if ($this->session->get('idrol') === '1') {
        
        $iduser = $this->session->get('iduser');
        return $cursosModel->getCursosByTeacher($iduser);
    } elseif ($this->session->get('idrol') === '2') {
        return $cursosModel->obtenerCursos();
    }

    return [];
}
public function agregar()
{
    $cursoModel = new CursoModel();

    if ($this->request->getMethod() === 'post') {
        $data = [
            'nombre_curso' => $this->request->getPost('nombre_curso'),
            'nivel_curso' => $this->request->getPost('nivel_curso'),
        ];

        $cursoModel->insert($data);
        return redirect()->to('crud_cursos')->with('success', 'Curso agregado correctamente');
    }

    // Cargar la vista de agregar curso
    return view('components/agregar_curso');
}

public function editar($id)
{
    $cursoModel = new CursoModel();

    if ($this->request->getMethod() === 'post') {
        $data = [
            'nombre_curso' => $this->request->getPost('nombre_curso'),
            'nivel_curso' => $this->request->getPost('nivel_curso'),
        ];

        $cursoModel->update($id, $data);
        return redirect()->to('crud_cursos')->with('success', 'Curso editado correctamente');
    }

    // Obtener el curso por su ID y cargar la vista de editar
    $data['curso'] = $cursoModel->find($id);

    return view('components/editar_curso', $data);
}

public function eliminar($id)
{
    $cursoModel = new CursoModel();

    // Lógica para eliminar un curso
    $cursoModel->delete($id);

    return redirect()->to('crud_cursos')->with('success', 'Curso eliminado correctamente');
}
}


