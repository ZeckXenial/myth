<?php

namespace App\Controllers;

use App\Models\CursoModel;
use App\Models\CalificacionesModel;

class NotasController extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $cursosModel = new CursoModel();
        $calificacionesModel = new CalificacionesModel();

        $data['cursos'] = $cursosModel->obtenerCursos();
        
        return view('notas', $data);
    }

    public function crud($id_curso)
    {
        $calificacionesModel = new CalificacionesModel();

        $data['notas'] = $calificacionesModel->getNotasByCurso($id_curso);

        return view('crud_notas', $data);
    }
}
