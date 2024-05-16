<?php

namespace App\Controllers;

use App\Models\CursoModel;
use App\Models\CrudUsuarioModel;
use App\Models\AsistenciasModel;
use App\Models\CalificacionesModel;
use App\Models\AnotacionesModel;
use App\Models\AsignaturaModel;
use App\Models\EstudiantesModel;
use App\Models\AsignaturaCursoModel;
use App\Models\NivelModel;
use App\Models\ApoderadoModel;
use CodeIgniter\Controller;

class Cursos extends Controller
{
    private $cursoModel;
    private $nivelModel;
    private $anotacionesmodel;
    private $asistenciasmodel;
    private $calificacionesmodel;
    private $apoderadoModel;
    private $asignaturaModel;
    private $estudianteModel;
    private $asignaturaCursoModel;
    private $crudUsuarioModel;

    public function __construct()
    {
        $this->cursoModel = new CursoModel();
        $this->calificacionesmodel = new calificacionesModel();
        $this->asistenciasmodel = new asistenciasModel();
        $this->anotacionesmodel = new anotacionesModel();
        $this->apoderadoModel = new ApoderadoModel();
        $this->estudianteModel = new EstudiantesModel();
        $this->nivelModel = new NivelModel();
        $this->asignaturaModel = new AsignaturaModel();
        $this->asignaturaCursoModel = new AsignaturaCursoModel();
        $this->crudUsuarioModel = new CrudUsuarioModel();
    }

    public function index()
    {
        
        $idrol = session()->get('idrol');

        if ($idrol === '1') {
           
            $data['cursos'] = $this->cursoModel->obtener;

        } elseif ($idrol === '2' || $idrol === '3') {
            $data['cursos'] = $this->cursoModel->obtenerCursos();
        } else {
            // Otros roles
            $data['cursos'] = [];
        }

        return view('cursos/index', $data);
    }
    

    public function editar($id)
    {
        $data['curso'] = $this->cursoModel->obtenerCursoPorId($id);
        $data['asignaturas'] = $this->asignaturaModel->obtenerAsignaturas($id);
        $data['usuarios'] = $this->crudUsuarioModel->obtenerUsuarios();
        $data['niveles'] = $this->nivelModel->obtenerNiveles();
        if (!$id) {
            return redirect()->to(site_url('cursos'))->with('error', 'El curso no existe.');
        }
        return view('components/edit', $data);
    }
    public function guardar()
    {
        if ($this->request->getMethod() === 'post') {
            $user_id = $this->request->getPost('user_id');
            $grado = $this->request->getPost('grado');
            $nivel_id = $this->request->getPost('nivel_id');

            $data = ['user_id' => $user_id, 'grado' => $grado, 'nivel_id' => $nivel_id];
            $curso_id = $this->cursoModel->insert($data);

            if ($curso_id) {
                return redirect()->to(site_url('cursos'))->with('success', 'Curso agregado exitosamente');
            } else {
                return redirect()->to(site_url('cursos'))->with('error', 'Error al agregar el curso');
            }
        }

        return redirect()->to(site_url('cursos'))->with('error', 'Error al procesar la solicitud');
    }
    public function agregar()
    {
        $nivelModel = new NivelModel();
        $asignaturaModel = new AsignaturaModel();
        $usuarioModel = new CrudUsuarioModel();

        $data['niveles'] = $nivelModel->findAll();
        $data['asignaturas'] = $asignaturaModel->findAll();
        $data['usuarios'] = $usuarioModel->findAll();

        return view('components/agregar', $data);
    }

    public function update($cursoId)
    {
        if ($this->request->getMethod() === 'post') {
            $data = [
                'grado' => $this->request->getPost('grado'),
                'user_id' => $this->request->getPost('user_id'),
                
                'nivel_id' => $this->request->getPost('nivel_id'),
            ];

            if ($this->cursoModel->actualizarCurso($cursoId, $data)) {
                $this->asignaturaCursoModel->eliminarAsignaturasCursoPorCursoId($cursoId);
            
                // Obtener las asignaturas seleccionadas
                $asignatura_ids = $this->request->getPost('asignatura_id');
            
                // Verificar si hay asignaturas seleccionadas
                if ($asignatura_ids !== null) {
                    // Iterar sobre las asignaturas seleccionadas
                    foreach ($asignatura_ids as $asignatura_id) {
                        $this->asignaturaCursoModel->insertarAsignaturaCurso($cursoId, $asignatura_id);
                    }
                }
            
                return redirect()->to(site_url('cursos'))->with('success', 'Curso actualizado exitosamente');
            } else {
                return redirect()->to(site_url('cursos'))->with('error', 'Error al actualizar el curso');
            }
            
        }

        return redirect()->to(site_url('cursos'))->with('error', 'Error al procesar la solicitud');
    }
    public function exportar($cursoId)
    {    
        
        $estudianteId = $this->request->getGet('estudiante_id');

        $anotaciones = $this->anotacionesmodel->obtenerAnotacionesPorEstudiante($estudianteId);

        $asistencias = $this->asistenciasmodel->obtenerAsistenciasPorEstudiante($estudianteId);

        $calificaciones = $this->calificacionesmodel->obtenerCalificacionesPorEstudiante($estudianteId);
        $estudiantes= $this->estudianteModel->obtenerEstudiantesPorCurso($cursoId);
        $data = [
            'anotaciones' => $anotaciones,
            'asistencias' => $asistencias,
            'calificaciones' => $calificaciones,
            'estudiantes' => $estudiantes
        ];
        return view('Components/exportar', $data);
        
    }
    public function exportarestudiante($estudianteId)
    {

        $anotaciones = $this->anotacionesmodel->obtenerAnotacionesPorEstudiante($estudianteId);

        $asistencias = $this->asistenciasmodel->obtenerAsistenciasPorEstudiante($estudianteId);

        $calificaciones = $this->calificacionesmodel->obtenerCalificacionesPorEstudiante($estudianteId);
       
        $data = [
            'anotaciones' => $anotaciones,
            'asistencias' => $asistencias,
            'calificaciones' => $calificaciones,
        ];
   
       return $this->response->setJSON($data);  

       
    }
    public function delete($id)
    {
        $this->cursoModel->eliminarCurso($id);
        return redirect()->to('cursos');
    }
}
