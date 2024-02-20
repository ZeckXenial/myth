<?php

namespace App\Controllers;

use App\Models\EstudiantesModel;
use App\Models\ApoderadoModel;
use CodeIgniter\Controller;

class Estudiantes extends Controller
{
    private $estudiantesModel;
    private $apoderadoModel;

    public function __construct()
    {
        $this->estudiantesModel = new EstudiantesModel();
        $this->apoderadoModel = new ApoderadoModel();
    }

    public function index()
    {
        $data['estudiantes'] = $this->estudiantesModel->findAll();
        return view('estudiantes/index', $data);
    }

    public function agregar()
    {
        $data['apoderados'] = $this->apoderadoModel->findAll();
        return view('estudiantes/agregar', $data);
    }

    public function guardar()
{
    if ($this->request->getMethod() === 'post') {
        // Obtener los datos del formulario
        $estudianteData = [
            'nombre' => $this->request->getPost('nombre_estudiante'),
            'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento_estudiante'),
            'grado' => $this->request->getPost('grado'),
            'curso_id' => $this->request->getPost('curso_id') // Obtener el curso_id del formulario
        ];

        // Insertar el estudiante en la base de datos
        $estudianteId = $this->estudiantesModel->insert($estudianteData);

        // Verificar si se insertó correctamente
        if ($estudianteId) {
            // Obtener los apoderados seleccionados
            $apoderados = $this->request->getPost('apoderados');

            // Asociar los apoderados con el estudiante en la tabla intermedia
            foreach ($apoderados as $apoderadoId) {
                $this->apoderadoModel->asociarEstudiante($estudianteId, $apoderadoId);
            }

            return redirect()->to(site_url('estudiantes'))->with('success', 'Estudiante agregado exitosamente');
        } else {
            return redirect()->to(site_url('estudiantes'))->with('error', 'Error al agregar el estudiante');
        }
    }
}

    public function editar($id)
    {
        $data['estudiante'] = $this->estudiantesModel->find($id);
        $data['apoderados'] = $this->apoderadoModel->findAll();
        return view('estudiantes/editar', $data);
    }

    public function actualizar($id)
    {
        if ($this->request->getMethod() === 'post') {
            // Obtener los datos del formulario
            $estudianteData = [
                'nombre' => $this->request->getPost('nombre'),
                'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),
                'grado' => $this->request->getPost('grado'),
                'curso_id' => $this->request->getPost('curso_id')
            ];

            // Actualizar el estudiante en la base de datos
            $result = $this->estudiantesModel->update($id, $estudianteData);

            // Verificar si se actualizó correctamente
            if ($result) {
                // Actualizar los apoderados asociados con el estudiante en la tabla intermedia
                $apoderados = $this->request->getPost('apoderados');
                $this->apoderadoModel->actualizarAsociaciones($id, $apoderados);

                return redirect()->to(site_url('estudiantes'))->with('success', 'Estudiante actualizado exitosamente');
            } else {
                return redirect()->to(site_url('estudiantes'))->with('error', 'Error al actualizar el estudiante');
            }
        }
    }

    public function eliminar($id)
    {
        // Eliminar el estudiante de la base de datos
        $result = $this->estudiantesModel->delete($id);

        // Verificar si se eliminó correctamente
        if ($result) {
            // Eliminar las asociaciones del estudiante con los apoderados en la tabla intermedia
            $this->apoderadoModel->eliminarAsociacionesEstudiante($id);

            return redirect()->to(site_url('estudiantes'))->with('success', 'Estudiante eliminado exitosamente');
        } else {
            return redirect()->to(site_url('estudiantes'))->with('error', 'Error al eliminar el estudiante');
        }
    }
}
    

