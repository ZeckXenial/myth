<?php

namespace App\Controllers;

use App\Models\AnotacionesModel;

class Anotaciones extends BaseController
{
    private $anotacionesModel;

    public function __construct()
    {
        $this->anotacionesModel = new AnotacionesModel();
    }

    public function curso($cursoId)
    {
        $data['anotaciones'] = $this->anotacionesModel->obtenerAnotacionesPorCurso($cursoId);
        return view('components/anotaciones_curso', $data);
    }
}
