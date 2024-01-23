<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends Controller
{
    public function index()
    {
        return view('homepage');
    }

    public function login()
    {
        return  view('auth/login');
    }
}