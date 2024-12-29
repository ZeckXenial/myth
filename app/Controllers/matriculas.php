<?php

namespace App\Controllers;

use App\Models\matriculas_model;
use App\Models\cursomodel;

class Matriculas extends BaseController
{
    protected $matriculasModel;
    protected $cursomodel;

    public function __construct()
    {
        $this->cursomodel = new cursomodel();
        $this->matriculasModel = new matriculas_model();
    }

    public function index()
    {
        // Obtener todos los registros de matrículas con estudiantes y apoderados
        $data['cursos'] = $this->cursomodel->obtenerCursos(); 
       
        // Obtener las matrículas desde el modelo
        $data['matriculas'] = $this->matriculasModel->obtener_todos();
    
        // Filtrar las matrículas donde curso_id no sea null
        $data['matriculas'] = array_filter($data['matriculas'], function($matricula) {
            return $matricula->matricula_id !== null;
        });
    
        // Obtener cursos desde la base de datos
        return view('Components/matriculas', $data);
    }
    

    public function guardar()
    {
        try {
            // Datos del estudiante
            $estudianteData = [
                'nombre_estudiante' => $this->request->getPost('nombre_estudiante'),
                'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),
                'curso_id' => $this->request->getPost('curso_id'),
                'fecha_matricula' => $this->request->getPost('fecha_matricula'),
                'rut' => $this->request->getPost('rut_estudiante'),
            ];
    
            // Datos del apoderado
            $apoderadoData = [
                'nombre_apoderado' => $this->request->getPost('nombre_apoderado'),
                'numero_telefono' => $this->request->getPost('numero_telefono'),
                'email' => $this->request->getPost('email'),
                'fecha_matricula' => $this->request->getPost('fecha_matricula'),
                'rut' => $this->request->getPost('rut_apoderado'),
            ];
    
            // Datos de la matrícula
            $matriculaData = [
                'fecha_matriculacion' => $this->request->getPost('fecha_matricula'),
                'estado' => $this->request->getPost('estado'),
            ];
    
            // Llamar al modelo para procesar la transacción
            $this->matriculasModel->agregar_matricula($estudianteData, $apoderadoData, $matriculaData);
    
            // Redirigir con mensaje de éxito
            return redirect()->to('estudiantes')->with('success', 'Matrícula agregada exitosamente.');
    
        } catch (\Exception $e) {
            // Manejar el error y redirigir con mensaje de error
            return redirect()->to('estudiantes')->with('error', 'Error al guardar la matrícula: ' . $e->getMessage());
        }
    }
    

public function editar($estudiante_id, $apoderado_id,$matricula_id)
{
    
    // Pasar los dos IDs a la función obtener_por_id
    $data['matricula'] = $this->matriculasModel->obtener_por_id($estudiante_id, $apoderado_id);

    $data['estudiante_id'] = $estudiante_id;
    $data['apoderado_id'] = $apoderado_id;
    $data['matricula_id'] = $matricula_id;

    $data['cursos'] = $this->cursomodel->obtenerCursos();

    return view('Components/crud_apoderados', $data);
}


    public function actualizar($estudiante_id,$apoderado_id,$matricula_id)
{
    try {
        // Datos del estudiante
        $estudianteData = [
            'nombre_estudiante' => $this->request->getPost('nombre_estudiante'),
            'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),
            'curso_id' => $this->request->getPost('curso_id'),
            'fecha_matricula' => $this->request->getPost('fecha_matricula'),
            'rut' => $this->request->getPost('rut_estudiante'),
        ];
        
        // Datos del apoderado
        $apoderadoData = [
            'nombre_apoderado' => $this->request->getPost('nombre_apoderado'),
            'numero_telefono' => $this->request->getPost('numero_telefono'),
            'email' => $this->request->getPost('email'),
            'fecha_matricula' => $this->request->getPost('fecha_matricula'),
            'rut' => $this->request->getPost('rut_apoderado'),
        ];

        // Datos de la matrícula
        $matriculaData = [
            'fecha_matriculacion' => $this->request->getPost('fecha_matricula'),
            'estado' => $this->request->getPost('estado'),
        ];
        
        // Actualizar datos en el modelo
        $resultadoEstudiante = $this->matriculasModel->actualizar_estudiante($estudiante_id, $estudianteData);
        $resultadoApoderado = $this->matriculasModel->actualizar_apoderado($apoderado_id, $apoderadoData);
        $resultadoMatricula = $this->matriculasModel->actualizar_matricula($matricula_id, $matriculaData);
        // Verificar que todos los datos se actualizaron correctamente
        if ($resultadoEstudiante && $resultadoApoderado && $resultadoMatricula) {
            return redirect()->to('matriculas')->with('success', 'Matrícula actualizada exitosamente.');
        } else {
            return redirect()->to('matriculas')->with('error', 'Hubo un problema al actualizar la matrícula.');
        }
    } catch (\Exception $e) {
        // En caso de excepción, redirigir con mensaje de error
        return redirect()->to('matriculas')->with('error', 'Error al actualizar la matrícula: ' . $e->getMessage());
    }
}

    public function eliminar($id)
    {
        try {
            // Eliminar la matrícula, estudiante y apoderado por ID de matrícula
            $this->matriculasModel->eliminar_matricula($id);
            return redirect()->to('matriculas')->with('success', 'Matrícula eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->to('matriculas')->with('error', 'Error al eliminar la matrícula: ' . $e->getMessage());
        }
    }
}
