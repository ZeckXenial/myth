<?php

namespace App\Controllers;

use App\Models\ApoderadoModel; 
use App\Models\EstudiantesModel; 
use App\Models\AnotacionesModel; 

class CrudApoderados extends BaseController
{
    public function index()
    {
        $model = new ApoderadoModel();
        $data['apoderados'] = $model->findAll(); // Obtén todos los apoderados

        // Carga la vista correspondiente con los datos
        return view('components/crud_apoderados', $data);
    }

    public function agregar()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'rut' => 'required',
            'nombre' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
            'fecha_nace' => 'required|valid_date',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->to('crud_apoderados')->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'rut_apoderado' => $this->request->getPost('rut'),
            'nombre_apoderado' => $this->request->getPost('nombre'),
            'telefono_apoderado' => $this->request->getPost('telefono'),
            'direccion_apoderado' => $this->request->getPost('direccion'),
            'fechanace_apoderado' => $this->request->getPost('fecha_nace'),
        ];

        $apoderadosModel = new ApoderadoModel();
        $apoderadosModel->insert($data);

        return redirect()->to('crud_apoderados');
    }

    public function editar($rutApoderado)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nombre' => 'required',
            'telefono' => 'required',
            'direccion' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->to('crud_apoderados')->withInput()->with('errors', $validation->getErrors());
        }
       
        $data = [
            'nombre_apoderado' => $this->request->getPost('nombre'),
            'telefono_apoderado' => $this->request->getPost('telefono'),
            'direccion_apoderado' => $this->request->getPost('direccion'),
        ];

        // Actualiza el registro en la base de datos usando el nuevo método
        $apoderadosModel = new ApoderadoModel();
        $apoderadosModel->actualizarApoderado($rutApoderado, $data);

        return redirect()->to('crud_apoderados');
    }

    public function eliminar($rutApoderado)
    {
        $apoderadosModel = new ApoderadoModel();
        $estudiantesModel = new EstudiantesModel();
        $anotacionesModel = new AnotacionesModel();
    
        $estudiantesAsociados = $estudiantesModel->where('rut_apoderado', $rutApoderado)->findAll();
    
        foreach ($estudiantesAsociados as $estudiante) {
            $anotacionesModel->where('Rut_estudiante', $estudiante['rut_estudiante'])->delete();
        }
    
        $estudiantesModel->where('rut_apoderado', $rutApoderado)->delete();
    
        $apoderadosModel->delete($rutApoderado);
    
        return redirect()->to('crud_apoderados');
    }
}
