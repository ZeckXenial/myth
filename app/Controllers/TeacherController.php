<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class TeacherController extends Controller
{
    public function loadCrudUsuarios()
    {
        return view('components/crud_usuarios');
    }

    public function dashboard()
    {
      

        return view('admin/dashboard');
    }

    public function admin()
    {   
       


        return view('admin/dashboard');
    }
}
