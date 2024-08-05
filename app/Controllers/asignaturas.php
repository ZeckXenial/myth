<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AsignaturaModel;
use App\Models\asignaturacursoModel;
use App\Models\CrudUsuarioModel;
use App\Models\CursoModel;
use CodeIgniter\Model;

class Asignaturas extends Controller
{
    private $usuariosmodel;
    private $Cursomodel;
    private $asignaturacursoModel;
    private $asignaturaModel;

    public function __construct() {
        $this->usuariosmodel = new CrudusuarioModel;
        $this->asignaturaModel = new AsignaturaModel();
        $this->asignaturacursoModel = new asignaturacursoModel();
        $this->Cursomodel = new Cursomodel();
    }
    public function index()
    {
        
        $data['asignaturas'] = $this->asignaturaModel->obtenerAsignaturas();
        
        return view('asignaturas/index', $data);
    }
    public function asignaturas (){
        $user_id = session()->get('iduser');
        $data['usuarios'] = $this->usuariosmodel->obtenerprofesores();
        $data['cursos'] = $this->Cursomodel->obtenerCursos();
        return view('components/crear', $data);
    }
    public function crear()
    {
        if ($this->request->getMethod() === 'post') {
           

            $asignaturadata = [
                'nombre_asignatura' => $this->request->getPost('nombre_asignatura'),
                'user_id' => $this->request->getPost('user_id')

            ];
            $this->asignaturaModel->crearAsignatura($asignaturadata);   
            $asignaturaid = $this->asignaturaModel->getInsertID();
            $cursoid= $this->request->getPost('curso_id');
            
            $this->asignaturacursoModel->insertarAsignaturaCurso( $cursoid,$asignaturaid);
            return redirect()->to(site_url('cursos'))->with('success', 'Asignatura creada correctamente');
        }

        return view('components/crear');
    }

    public function editar($id)
    {
        $asignaturaModel = new AsignaturaModel();
        $data['asignatura'] = $asignaturaModel->obtenerAsignaturaPorId($id);
        $data['usuarios'] = $this->usuariosmodel->obtenerUsuarios();
        if ($this->request->getMethod() === 'post') {
            $dataUpdate = [
                'nombre' => $this->request->getPost('nombre_asignatura'),
                'user_id' => $this->request->getPost('user_id')
            ];

            $asignaturaModel->actualizarAsignatura($id, $dataUpdate);

            return redirect()->to(site_url('cursos'))->with('success', 'Asignatura actualizada correctamente');
        }

        return view('Components/asignatura_edit', $data);
    }

    public function eliminar($id)
    {
        $asignaturaModel = new AsignaturaModel();
        $asignaturaModel->eliminarAsignatura($id);

        return redirect()->to(site_url('cursos'))->with('success', 'Asignatura eliminada correctamente');
    }
}
