<?php

namespace App\Controllers;

use App\Models\CursoModel;
use CodeIgniter\Controller;

class Cursos extends Controller
{
    public function index()
    {
        $cursoModel = new CursoModel();
        $data['cursos'] = $cursoModel->findAll();
        return view('cursos/index', $data);
    }

    public function create()
    {
        return view('cursos/create');
    }

    public function store()
    {
        $cursoModel = new CursoModel();
        $cursoModel->insert($this->request->getPost());
        return redirect()->to('/cursos');
    }

    public function edit($id)
    {
        $cursoModel = new CursoModel();
        $data['curso'] = $cursoModel->find($id);
        return view('cursos/edit', $data);
    }

    public function update($id)
    {
        $cursoModel = new CursoModel();
        $cursoModel->update($id, $this->request->getPost());
        return redirect()->to('/cursos');
    }

    public function delete($id)
    {
        $cursoModel = new CursoModel();
        $cursoModel->delete($id);
        return redirect()->to('/cursos');
    }
}
