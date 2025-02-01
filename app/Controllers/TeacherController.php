<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class TeacherController extends Controller
{
    public function loadCrudUsuarios()
    {
        return view('Components/crud_usuarios');
    }

    public function dashboard()
    {
      

        return view('Admin/Dashboard');
    }

    public function admin()
    {   
       


        return view('Admin/Dashboard');
    }
}
