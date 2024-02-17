<?php

namespace App\Controllers;

use App\Models\CursoModel;
use CodeIgniter\Controller;

class Cursos extends Controller
{
    private $cursoModel;

    public function __construct()
    {
        $this->cursoModel = new CursoModel();
    }

    public function index()
    {
        $data['cursos'] = $this->cursoModel->findAll();
        return view('cursos/index', $data);
    }

    public function create()
    {
        return view('cursos/create');
    }

    public function store()
    {
        $this->cursoModel->insert($this->request->getPost());
        return redirect()->to('/cursos');
    }

    public function edit($id)
    {
        $data['curso'] = $this->cursoModel->find($id);
        return view('components/edit', $data);
    }

    public function update($id)
    {
        $this->cursoModel->update($id, $this->request->getPost());
        return redirect()->to('/cursos');
    }

    public function delete($id)
    {
        $this->cursoModel->delete($id);
        return redirect()->to('/cursos');
    }
}
