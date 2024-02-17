<?php

namespace App\Controllers;

use App\Models\EstudiantesModel;
use App\Models\nivelModel;

class CrudEstudiantes extends BaseController
{
    public function index()
    {
        $estudianteModel = new EstudiantesModel();
        $nivelModel = new nivelModel();
        $data['estudiantes'] = $estudianteModel->obtenerEstudiantesConApoderados();
        $data['niveles'] = $nivelModel->obtenerniveles();

        return view('components/estudiantes', $data);
    }

    public function agregar()
    {
        $estudianteModel = new EstudiantesModel();

        if ($this->request->getMethod() === 'post') {
            $data = [
                'nombre' => $this->request->getPost('nombre_estudiante'),
                'fecha_nacimiento' => $this->request->getPost('fecha_nace'),
                'grado' => $this->request->getPost('grado'),
            ];

            $estudianteModel->insert($data);
            return redirect()->to('crud_estudiantes')->with('success', 'Estudiante agregado correctamente');
        }

        // Cargar la vista de agregar estudiante
        return view('components/agregar_estudiante');
    }

    public function editar($id)
    {
        $estudianteModel = new EstudiantesModel();

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
