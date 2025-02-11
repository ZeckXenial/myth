<?php

namespace App\Controllers;

use App\Models\horario;
use App\Models\usuarioModel;
use App\Models\asignaturaModel;
use App\Models\cursoModel;
use CodeIgniter\Controller;

class HorarioClaseController extends BaseController
{
    protected $horarioModel;
    protected $asignaturaModel;
    protected $cursoModel;
    protected $usuarioModel;

    public function __construct() {
        $this->horarioModel = new Horario();
        $this->asignaturaModel = new AsignaturaModel();
        $this->cursoModel = new CursoModel();
        $this->usuarioModel = new UsuarioModel();
    }

    public function listarHorarios() {
        $userRole = session()->get('role');
        $profesor_id = session()->get('iduser'); // ID del usuario autenticado

        if ($userRole === 'Profesor') {
            // Si es profesor, solo puede ver sus propios horarios
            $horarios = $this->horarioModel->where('user_id', $profesor_id)->findAll();
        } else {
            // Si es administrador u otro rol, puede ver todos los horarios
            $horarios = $this->horarioModel->findAll();
        }

        $profesores = $this->usuarioModel->select('user_id, nombre')->where('id_rol', 1)->findAll();
        $cursos = $this->cursoModel->getAllCursosAndAsignaturas();

        return view('listar_horarios', [
            'horarios' => $horarios,
            'userRole' => $userRole,
            'profesores' => $profesores,
            'cursos' => $cursos
        ]);
    }
    public function getAsignaturasPorProfesor($profesor_id) {
        $asignaturasModel = new AsignaturaModel();
        $asignaturas = $asignaturasModel->where('user_id', $profesor_id)->findAll(); 
        return $this->response->setJSON($asignaturas);
    }
    public function crearHorario() {
        // Obtener datos del formulario
        
            $curso_id = $this->request->getPost('curso_id');
            $asignatura_id = $this->request->getPost('asignatura_id');
            $profesor_id = $this->request->getPost('profesor_id');
            $dia_semana = $this->request->getPost('dia_semana');
            $hora_inicio = $this->request->getPost('hora_inicio');
            $hora_fin = $this->request->getPost('hora_fin');
            $recurrencia = $this->request->getPost('recurrencia');
    
        // Intentar insertar datos en la base de datos
        try {
            if ($this->horarioModel->insertarHorario($profesor_id, $curso_id, $recurrencia ,$asignatura_id, $dia_semana, $hora_inicio, $hora_fin)) {
                return redirect()->to(site_url("cursos"))->with('success', 'Horario creado correctamente');
            } else {
                return redirect()->to(site_url("cursos"))->with('error', 'Error al crear el horario: datos inválidos');
            }
        } catch (\Exception $e) {
            return redirect()->to(site_url("cursos"))->with('error', 'Error al crear el horario: ' . $e->getMessage());
        }
    }
    public function getHorariosPorCurso($curso_id) {
        $userRole = session()->get('role');
        $profesor_id = session()->get('user_id');
    
        // Si el usuario es profesor, solo puede ver los horarios asignados a él
        if ($userRole === 'Profesor') {
            $this->horarioModel->where('profesor_id', $profesor_id);
        }
    
        $horarios = $this->horarioModel
            ->select('horarios_clases.recurrencia as recurrencia, horarios_clases.horario_id, asignaturas.nombre_asignatura AS asignatura_nombre, cursos.grado AS curso_nombre, dia_semana, hora_inicio, hora_fin')
            ->join('asignaturas', 'asignaturas.asignatura_id = horarios_clases.asignatura_id')
            ->join('cursos', 'cursos.curso_id = horarios_clases.curso_id')
            ->where('horarios_clases.curso_id', $curso_id)
            ->findAll();
    
        // Obtener el lunes de la semana actual
        $fechaInicioSemana = date('Y-m-d', strtotime('monday this week'));
    
        // Array de días dinámicos basado en la semana actual
        $dias = [
            "Lunes" => $fechaInicioSemana,
            "Martes" => date('Y-m-d', strtotime($fechaInicioSemana . ' +1 day')),
            "Miércoles" => date('Y-m-d', strtotime($fechaInicioSemana . ' +2 days')),
            "Jueves" => date('Y-m-d', strtotime($fechaInicioSemana . ' +3 days')),
            "Viernes" => date('Y-m-d', strtotime($fechaInicioSemana . ' +4 days')),
        ];
    
        $eventos = [];
        foreach ($horarios as $horario) {
            $eventos[] = [
                'id'    => $horario['horario_id'],
                'title' => $horario['asignatura_nombre'],
                'start' => isset($dias[$horario['dia_semana']]) ? $dias[$horario['dia_semana']] . 'T' . $horario['hora_inicio'] : null,
                'end'   => isset($dias[$horario['dia_semana']]) ? $dias[$horario['dia_semana']] . 'T' . $horario['hora_fin'] : null,
                'description' => 'Curso: ' . $horario['curso_nombre'] . ', Día: ' . $horario['dia_semana'],
                'recurrencia' => $horario['recurrencia']
            ];
        }
    
        return $this->response->setJSON($eventos);
    }
    
   public function convertirRecurrencia($recurrencia) {
        switch (strtolower($recurrencia)) {
            case 'diario':
                return 'daily';
            case 'semanal':
                return 'weekly';
            case 'mensual':
                return 'monthly';
            case 'anual':
                return 'yearly';
            default:
                return '';
        }
    }
    
    // Función para calcular las fechas de recurrencia
   
    public function editarHorario($horario_id) {
        $userRole = session()->get('role');

        if ($userRole === 'Profesor') {
            return redirect()->to('/horarios')->with('error', 'No tienes permiso para editar horarios.');
        }

        $horario = $this->horarioModel->find($horario_id);
        $jsonData = $this->request->getJSON();
        $dia_semana = $jsonData->dia_semana ?? null;
        $hora_inicio = $jsonData->hora_inicio ?? null;
        $hora_fin = $jsonData->hora_fin ?? null;
        if ($this->request->getMethod() === 'post') {
           
           
            try {
                $this->horarioModel->editarHorario($horario_id, $dia_semana, $hora_inicio, $hora_fin);
                return $this->response->setJSON(['success' => true, 'message' => 'Horario editado exitosamente.']);
            } catch (\Exception $e) {
                return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        return $this->response->setJSON(['success' => false, 'message' => 'Método no permitido.']);

        
    }

    public function eliminarHorario($horario_id) {
        $userRole = session()->get('role');

        if ($userRole === 'Profesor') {
            return redirect()->to('/horarios')->with('error', 'No tienes permiso para eliminar horarios.');
        }

        $this->horarioModel->delete($horario_id);
        return redirect()->to('/horarios')->with('success', 'Horario eliminado exitosamente.');
    }

    public function getCursosPorProfesor($profesor_id) {
        $userRole = session()->get('role');
        $userId = session()->get('user_id');

        // Si el usuario es profesor, solo obtiene sus propios cursos
        if ($userRole === 'Profesor' && $userId != $profesor_id) {
            return $this->response->setJSON([]);
        }

        $cursos = $this->horarioModel->getCursosPorProfesor($profesor_id);
        return $this->response->setJSON($cursos);
    }
}

