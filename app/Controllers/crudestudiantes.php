<?php

namespace App\Controllers;

use App\Models\EstudiantesModel;
use App\Models\ApoderadoModel;
use App\Models\apoderado_estudiante;
use App\Models\CursoModel;

class CrudEstudiantes extends BaseController
{
    private $estudianteModel;
    private $apoderadoModel;
    private $cursoModel;
    private $apoderado_estudiante;
    public function __construct() {
        $this->estudianteModel = new EstudiantesModel();
        $this->apoderadoModel = new ApoderadoModel();
        $this->apoderado_estudiante = new apoderado_estudiante();
        $this->cursoModel = new CursoModel();
    }
    public function index()
    {
        
        $data['estudiantes'] = $this->apoderado_estudiante->obtenerEstudiantesConApoderados();
        $data['cursos'] = $this->cursoModel->getCursosByDirective();
        $data['apoderados'] = $this->apoderadoModel->obtenerApoderados();
        

        return view('components/estudiantes', $data);
    }

    public function agregar()
    {
   

        if ($this->request->getMethod() === 'post') {
            $estudiantedata = [
                'nombre_estudiante' => $this->request->getPost('nombre_estudiante'),
                'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento_estudiante'),
            ];
            $apoderadodata = [
                'email' => $this->request->getPost('email_apoderado'),
                'nombre_apoderado' => $this->request->getPost('nombre_apoderado'),
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
            $dataEstudiante = [
                'nombre_estudiante' => $this->request->getPost('nombre_estudiante'),
                'fecha_nacimiento' => $this->request->getPost('fechaNacimientoEstudiante'),
                'curso_id' => $this->request->getPost('curso_id')
            ];

            if (!empty($dataEstudiante)) {
                $this->estudianteModel->update($id, $dataEstudiante);
            }
    
            $apoderadoData = [
                'nombre_apoderado' => $this->request->getPost('nombre_apoderado'),
                'numero_telefono' => $this->request->getPost('telefono_apoderado'),
                'email' => $this->request->getPost('email')
            ];
            
            if (!empty(array_filter($apoderadoData))) {
                $query = $this->apoderadoModel->editarapoderado($id, $apoderadoData);

                return redirect()->to('estudiantes')->with('success', 'Apoderado editado correctamente');
               
            }
    
            return redirect()->to('estudiantes')->with('success', 'Estudiante editado correctamente');
        }
    
        $data['estudiante'] = $this->estudianteModel->find($id);
    
        return view('components/estudiantes', $data);
    }
    


    public function eliminar($id)
    {
        
    
        $this->apoderado_estudiante->where('estudiantes_id', $id)->delete();
    
        return redirect()->to('estudiantes')->with('success', 'Estudiante eliminado correctamente');
    }
}
