<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Controllers\CheckSession;

class AdminController extends Controller
{
    public function __construct()
    {
        // Cargar el controlador de verificación de sesión
        $this->CheckSession = new CheckSession();
        helper(['url', 'cookie', 'html']);
    }
    public function dashboard()
    {
        return view('admin/dashboard');
    }
}