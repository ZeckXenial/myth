<?php

namespace App\Controllers;

use App\Models\asistenciamodel;
use App\Models\estudiantemodel;
use App\Models\cursomodel;

class CrudAsistencias extends BaseController
{
    public function index()
    {
        $asistenciamodel = new asistenciamodel();
        $data['asistencias'] = $asistenciamodel->findAll();
    
        $estudiantemodel = new estudiantemodel();
        $data['estudiantes'] = $estudiantemodel->findAll();
    
        $nombresEstudiantes = [];
        foreach ($data['estudiantes'] as $estudiante) {
            $nombresEstudiantes[$estudiante['rut_estudiante']] = $estudiante['nombre_estudiante'];
        }
        $data['nombres_estudiantes'] = $nombresEstudiantes;
    
        return view('components/asistencia', $data);
    }

    public function agregar()
    {
        $asistenciamodel = new asistenciamodel();
        $estudiantemodel = new estudiantemodel();
        $cursomodel = new cursomodel();

        if ($this->request->getMethod() === 'post') {
            $data = [
                'rut_estudiante' => $this->request->getPost('rut_estudiante'),
                'fecha_asistencia' => date('Y-m-d H:i:s'),
                'asistio' => $this->request->getPost('asistio'),
                'semestre' => $this->request->getPost('semestre'),
                'iduser' => $this->request->getPost('iduser'),
            ];

            // Verificar si el estudiante y el curso existen antes de insertar la asistencia
            $estudianteExists = $estudiantemodel->where('rut_estudiante', $data['rut_estudiante'])->first();
            $cursoExists = $cursomodel->where('id_curso', $estudianteExists['id_curso'])->first();

            if ($estudianteExists && $cursoExists) {
                $asistenciamodel->insert($data);
                return redirect()->to('crud_asistencias')->with('success', 'Asistencia agregada correctamente');
            } else {
                return redirect()->to('crud_asistencias')->with('error', 'Error al agregar asistencia. Estudiante o curso no encontrados.');
            }
        }

        // Obtener lista de estudiantes y cursos para el formulario
        $data['estudiantes'] = $estudiantemodel->findAll();
        $data['cursos'] = $cursomodel->findAll();

        // Cargar la vista de agregar asistencia
        return view('components/agregar_asistencia', $data);
    }

    public function editar($id)
    {
        $asistenciamodel = new asistenciamodel();

        if ($this->request->getMethod() === 'post') {
            // L¨®gica para editar una asistencia
            $data = [
                'asistio' => $this->request->getPost('asistio'),
                'semestre' => $this->request->getPost('semestre'),
            ];

            $asistenciamodel->update($id, $data);
            return redirect()->to('crud_asistencias')->with('success', 'Asistencia editada correctamente');
        }

        // Obtener la asistencia por su ID y cargar la vista de editar
        $data['asistencia'] = $asistenciamodel->find($id);

        return view('components/editar_asistencia', $data);
    }

    public function eliminar($id)
    {
        $asistenciamodel = new asistenciamodel();

        // L¨®gica para eliminar una asistencia
        $asistenciamodel->delete($id);

        return redirect()->to('crud_asistencias')->with('success', 'Asistencia eliminada correctamente');
    }
}
