<?php

namespace App\Controllers;

use App\Models\EstudiantesModel;

class CrudEstudiantes extends BaseController
{
    public function index()
    {
        $estudianteModel = new EstudiantesModel();
        $data['estudiantes'] = $estudianteModel->findAll();

        return view('components/estudiantes', $data);
    }

    public function agregar()
    {
        $estudianteModel = new EstudiantesModel();

        if ($this->request->getMethod() === 'post') {
            $data = [
                'rut_estudiante' => $this->request->getPost('rut_estudiante'),
                'nombre_estudiante' => $this->request->getPost('nombre_estudiante'),
                'cod_est' => $this->request->getPost('cod_est'),
                'rut_apoderado' => $this->request->getPost('rut_apoderado'),
                'fecha_nace' => $this->request->getPost('fecha_nace'),
                'id_curso' => $this->request->getPost('id_curso'),
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
                'nombre_estudiante' => $this->request->getPost('nombre_estudiante'),
                'cod_est' => $this->request->getPost('cod_est'),
                'rut_apoderado' => $this->request->getPost('rut_apoderado'),
                'fecha_nace' => $this->request->getPost('fecha_nace'),
                'id_curso' => $this->request->getPost('id_curso'),
            ];

            $estudianteModel->update($id, $data);
            return redirect()->to('crud_estudiantes')->with('success', 'Estudiante editado correctamente');
        }

        // Obtener el estudiante por su ID y cargar la vista de editar
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
