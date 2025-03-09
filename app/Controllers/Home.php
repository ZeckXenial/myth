<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends Controller
{
    public function index()
    {
        return view('Auth/login');
    }

    public function login()
    {
        return  view('Auth/login');
    }
}