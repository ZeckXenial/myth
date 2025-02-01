<?php

namespace App\Controllers;

use App\Models\horario; // Asegúrate de que este es el modelo correcto
use App\Models\usuarioModel;
use App\Models\AsignaturaModel;
use App\Models\CursoModel;

class HorarioClaseController extends BaseController
{
    protected $horarioModel;

    public function __construct() {
        $this->horarioModel = new horario();
    }

    public function listarHorarios() {
        $profesor_id = session()->get('profesor_id');
        $horarios = $this->horarioModel->consultarHorarios($profesor_id);
        $userRole = session()->get('role');
    
        // Obtener usuarios con rol de profesor
        $usuariosModel = new UsuarioModel();
        $profesores = $usuariosModel->where('id_rol', 1)->findAll();
    
        // Obtener cursos con el nombre del nivel
        $cursosModel = new CursoModel();
        $cursos = $cursosModel->getAllCursosAndAsignaturas(); // Usar el método actualizado
    
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
        if ($this->request->getMethod() === 'post') {
            $data = [
                'profesor_id' => $this->request->getPost('profesor_id'),
                'curso_id' => $this->request->getPost('curso_id'), // Asegúrate de que este campo esté presente
                'asignatura_id' => $this->request->getPost('asignatura_id'),
                'dia_semana' => $this->request->getPost('dia_semana'),
                'hora_inicio' => $this->request->getPost('hora_inicio'),
                'hora_fin' => $this->request->getPost('hora_fin'),
            ];
    
            try {
                $this->horarioModel->insertarHorario(
                     $data['profesor_id'],
                        $data['curso_id'], // Asegúrate de que este campo esté presente
                   $data['asignatura_id'],
                      $data['dia_semana'],
                     $data['hora_inicio'],
                        $data['hora_fin']
                );
                return redirect()->to('/horarios')->with('success', 'Horario creado exitosamente.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }


        // Obtener usuarios con rol de profesor
        $usuariosModel = new UsuarioModel();
        $profesores = $usuariosModel->where('rol', 1)->findAll();

        // Obtener asignaturas del usuario
        $asignaturasModel = new AsignaturaModel();
        $asignaturas = $asignaturasModel->findAll(); // O filtrar según el usuario

        // Obtener cursos del usuario
        $cursosModel = new CursoModel();
        $cursos = $cursosModel->findAll(); // O filtrar según el usuario

        return view('crear_horario', [
            'profesores' => $profesores,
            'asignaturas' => $asignaturas,
            'cursos' => $cursos
        ]);
    }

    public function editarHorario($horario_id) {
        $userRole = session()->get('role'); // Obtener el rol del usuario

        // Verificar si el usuario es profesor
        if ($userRole === 'profesor') {
            return redirect()->to('/horarios')->with('error', 'No tienes permiso para editar este horario.');
        }

        $horario = $this->horarioModel->find($horario_id);

        if ($this->request->getMethod() === 'post') {
            $data = [
                'profesor_id' => $this->request->getPost('profesor_id'),
                'curso_id' => $this->request->getPost('curso_id'),
                'dia_semana' => $this->request->getPost('dia_semana'),
                'hora_inicio' => $this->request->getPost('hora_inicio'),
                'hora_fin' => $this->request->getPost('hora_fin'),
                'anio_escolar' => $this->request->getPost('anio_escolar'),
            ];

            try {
                $this->horarioModel->editarHorario(
                    $horario_id,
                    $data['profesor_id'],
                    $data['curso_id'],
                    $data['dia_semana'],
                    $data['hora_inicio'],
                    $data['hora_fin'],
                    $data['anio_escolar']
                );
                return redirect()->to('/horarios')->with('success', 'Horario editado exitosamente.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }

        // Obtener usuarios con rol de profesor
        $usuariosModel = new usuarioModel();
        $profesores = $usuariosModel->where('id_rol', 1)->findAll();

        // Obtener asignaturas del usuario
        $asignaturasModel = new AsignaturaModel();
        $asignaturas = $asignaturasModel->findAll(); // O filtrar según el usuario

        // Obtener cursos del usuario
        $cursosModel = new CursoModel();
        $cursos = $cursosModel->findAll(); // O filtrar según el usuario

        return view('editar_horario', [
            'horario' => $horario,
            'profesores' => $profesores,
            'asignaturas' => $asignaturas,
            'cursos' => $cursos
        ]);
    }

    public function eliminarHorario($horario_id) {
        $this->horarioModel->eliminarHorario($horario_id);
        return redirect()->to('/horarios')->with('success', 'Horario eliminado exitosamente.');
    }

    public function getCursosPorProfesor($profesor_id) {
        $cursos = $this->horarioModel->getCursosPorProfesor($profesor_id);
        return $this->response->setJSON($cursos);
    }
}