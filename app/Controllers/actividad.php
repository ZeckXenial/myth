<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\actividades;
use App\Models\AsignaturaModel;
use App\Models\CursoModel;

class Actividad extends Controller
{
    private $actividadesModel;
    private $asignaturaModel;
    private $cursoModel;

    public function __construct() {
        $this->actividadesModel = new actividades();
        $this->asignaturaModel = new AsignaturaModel();
        $this->cursoModel = new CursoModel();
    }

    
    public function mostrarFormulario($curso_id, $asignatura_id)
{
    $fecha_actividad = date('Y-m-d');
    $actividadExistente = $this->actividadesModel->verificarActividadDelDia($curso_id, $asignatura_id, $fecha_actividad);

    $data['curso'] = $this->cursoModel->obtenerCursoPorId($curso_id);
    $data['asignatura'] = $this->asignaturaModel->obtenerAsignaturaPorId($asignatura_id);

    if ($actividadExistente) {
        // Si existe la actividad, pasar los datos a la vista
        $data['glosaExistente'] = $actividadExistente['glosa'];
        $data['nombreResponsable'] = $actividadExistente['nombre_responsable'];
        $data['actividadRegistrada'] = true;
    } else {
        // Si no existe, simplemente no pasamos datos de actividad previa
        $data['actividadRegistrada'] = false;
    }

    return view('components/formulario_actividad', $data);
}
    public function registrarActividad()
    {
        if ($this->request->getMethod() === 'post') {
            $curso_id = $this->request->getPost('curso_id');
            $asignatura_id = $this->request->getPost('asignatura_id');
            $user_id = session()->get('iduser'); 
            $glosa = $this->request->getPost('glosa');
            $fecha_actividad = date('Y-m-d'); 

            $actividadExistente = $this->actividadesModel->verificarActividadDelDia($curso_id, $asignatura_id, $fecha_actividad);

            if ($actividadExistente) {
                return redirect()->back()->with('error', 'Ya existe una actividad registrada para esta asignatura y curso en el día de hoy.');
            }

            $nuevaActividad = [
                'user_id' => $user_id,
                'curso_id' => $curso_id,
                'asignatura_id' => $asignatura_id,
                'glosa' => $glosa,
                'fecha_actividad' => $fecha_actividad
            ];

            $this->actividadesModel->insertarActividad($nuevaActividad);

            return redirect()->back()->with('success', 'Actividad registrada correctamente.');
        }

        return redirect()->back()->with('error', 'Error al registrar la actividad.');
    }

    public function mostrarActividadesRecientes($curso_id, $asignatura_id)
{
    // Obtener actividades recientes ordenadas de más reciente a más antigua
    $actividadesRecientes = $this->actividadesModel->obtenerActividadesRecientesPorCursoYAsignatura($curso_id, $asignatura_id);

    $data = [
        'curso' => $this->cursoModel->obtenerCursoPorId($curso_id),
        'asignatura' => $this->asignaturaModel->obtenerAsignaturaPorId($asignatura_id),
        'actividades' => $actividadesRecientes
    ];

    return view('Components/visorActividades', $data);
}
}
