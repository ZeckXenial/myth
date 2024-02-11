<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\CursoModel;

class TeacherController extends Controller
{
    public function loadCrudUsuarios()
    {
        return view('components/crud_usuarios');
    }

    public function dashboard()
    {
        $cursoModel = new CursoModel();
        $rol = session()->get('role');
        $idUsuario = session()->get('user_id');

        $data['cursos'] = $cursoModel->obtenerCursosSegunRol($rol, $idUsuario);
        $data['cantCursos'] = $cursoModel->countCursos(); // Obtener la cantidad total de cursos

        return view('teacher/dashboard', $data);
    }

    public function admin()
    {
        return view('admin/dashboard');
    }
}
