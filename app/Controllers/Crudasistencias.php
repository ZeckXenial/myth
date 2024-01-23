<?php

namespace App\Controllers;

use App\Models\AsistenciaModel;
use App\Models\EstudianteModel;
use App\Models\CursoModel;

class CrudAsistencias extends BaseController
{
    public function index()
    {
        $asistenciaModel = new AsistenciaModel();
        $data['asistencias'] = $asistenciaModel->findAll();
    
        $estudianteModel = new EstudianteModel();
        $data['estudiantes'] = $estudianteModel->findAll();
    
        $nombresEstudiantes = [];
        foreach ($data['estudiantes'] as $estudiante) {
            $nombresEstudiantes[$estudiante['rut_estudiante']] = $estudiante['nombre_estudiante'];
        }
        $data['nombres_estudiantes'] = $nombresEstudiantes;
    
        return view('components/asistencia', $data);
    }

    public function agregar()
{
    $asistenciaModel = new AsistenciaModel();
    $estudianteModel = new EstudianteModel();
    $cursoModel = new CursoModel();

    if ($this->request->getMethod() === 'post') {
        $data = [
            'rut_estudiante' => $this->request->getPost('rut_estudiante'),
            'fecha_asistencia' => date('Y-m-d H:i:s'),
            'asistio' => $this->request->getPost('asistio'),
            'semestre' => $this->request->getPost('semestre'),
            'iduser' => $this->request->getPost('iduser'),
        ];

        // Verificar si el estudiante y el curso existen antes de insertar la asistencia
        $estudianteExists = $estudianteModel->where('rut_estudiante', $data['rut_estudiante'])->first();
        $cursoExists = $cursoModel->where('id_curso', $estudianteExists['id_curso'])->first();

        if ($estudianteExists && $cursoExists) {
            $asistenciaModel->insert($data);
            return redirect()->to('crud_asistencias')->with('success', 'Asistencia agregada correctamente');
        } else {
            return redirect()->to('crud_asistencias')->with('error', 'Error al agregar asistencia. Estudiante o curso no encontrados.');
        }
    }

    // Obtener lista de estudiantes y cursos para el formulario
    $data['estudiantes'] = $estudianteModel->findAll();
    $data['cursos'] = $cursoModel->findAll();

    // Cargar la vista de agregar asistencia
    return view('components/agregar_asistencia', $data);
}

public function editar($id)
{
    $asistenciaModel = new AsistenciaModel();

    if ($this->request->getMethod() === 'post') {
        // Lógica para editar una asistencia
        $data = [
            'asistio' => $this->request->getPost('asistio'),
            'semestre' => $this->request->getPost('semestre'),
        ];

        $asistenciaModel->update($id, $data);
        return redirect()->to('crud_asistencias')->with('success', 'Asistencia editada correctamente');
    }

    // Obtener la asistencia por su ID y cargar la vista de editar
    $data['asistencia'] = $asistenciaModel->find($id);

    return view('components/editar_asistencia', $data);
}

public function eliminar($id)
{
    $asistenciaModel = new AsistenciaModel();

    // Lógica para eliminar una asistencia
    $asistenciaModel->delete($id);

    return redirect()->to('crud_asistencias')->with('success', 'Asistencia eliminada correctamente');
}

}

