<?php

namespace App\Controllers;

use App\Models\EstudiantesModel;
use App\Models\ApoderadoModel;
use App\Models\apoderado_estudiante;
use App\Models\nivelModel;

class CrudEstudiantes extends BaseController
{
    private $estudianteModel;
    private $apoderadoModel;
    private $nivelModel;
    private $apoderado_estudiante;
    public function __construct() {
        $this->estudianteModel = new EstudiantesModel();
        $this->apoderadoModel = new ApoderadoModel();
        $this->apoderado_estudiante = new apoderado_estudiante();
        $this->nivelModel = new nivelModel();
    }
    public function index()
    {
        
        $data['estudiantes'] = $this->apoderado_estudiante->obtenerEstudiantesConApoderados();
        
        

        return view('components/estudiantes', $data);
    }

    public function agregar()
    {
   

        if ($this->request->getMethod() === 'post') {
            $estudiantedata = [
                'nombre' => $this->request->getPost('nombre_estudiante'),
                'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento_estudiante'),
            ];
            $apoderadodata = [
                'email' => $this->request->getPost('email_apoderado'),
                'nombre' => $this->request->getPost('nombre_apoderado'),
                'numero_telefono' => $this->request->getPost('telefono_apoderado'),
            ];
            

        $estudianteId = $this->estudianteModel->insert($estudiantedata);

        $estudianteId = $this->estudianteModel->insertID();

        $apoderadoId = $this->apoderadoModel->insert($apoderadodata);

        $apoderadoId = $this->apoderadoModel->insertID();

        $this->apoderado_estudiante->insertEstudianteApoderado($estudianteId, $apoderadoId);
            
            return redirect()->to('estudiantes')->with('success', 'Estudiante agregado correctamente');
        }

        return view('estudiantes');
    }

    public function editar($id)
    {
        

        if ($this->request->getMethod() === 'post') {
            $data = [
                'nombre' => $this->request->getPost('nombre_estudiante'),
                'fecha_nacimiento' => $this->request->getPost('fecha_nace'),
                'grado' => $this->request->getPost('grado'),
            ];

            $estudianteModel->update($id, $data);
            return redirect()->to('crud_estudiantes')->with('success', 'Estudiante editado correctamente');
        }

       
        $data['estudiante'] = $estudianteModel->find($id);

        return view('components/editar_estudiante', $data);
    }

    public function eliminar($id)
    {
        $estudianteModel = new EstudiantesModel();

        // Lógica para eliminar un estudiante
        $estudianteModel->delete($id);

        return redirect()->to('crud_estudiantes')->with('success', 'Estudiante eliminado correctamente');
    }
}
