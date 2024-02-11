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
        
        $idProfesor = $this->session->get('iduser');
        return $cursosModel->getCursosByTeacher($idProfesor);
    } elseif ($this->session->get('idrol') === '2') {
        return $cursosModel->obtenerCursos();
    }

    // En otros casos, devolver un array vacío o manejar según sea necesario
    return [];
}

}
