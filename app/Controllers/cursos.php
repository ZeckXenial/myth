<?php

namespace App\Controllers;





use App\Models\cursomodel;
use App\Models\crudusuariomodel;
use App\Models\asistenciasmodel;
use App\Models\calificacionesmodel;
use App\Models\anotacionesmodel;
use App\Models\asignaturamodel;
use App\Models\estudiantesmodel;
use App\Models\asignaturacursomodel;
use App\Models\nivelmodel;
use App\Models\apoderadomodel;
use App\Models\exportarcurso;




use App\Models\cursomodel;
use App\Models\crudusuariomodel;
use App\Models\asistenciasmodel;
use App\Models\calificacionesmodel;
use App\Models\anotacionesmodel;
use App\Models\asignaturamodel;
use App\Models\estudiantesmodel;
use App\Models\asignaturacursomodel;
use App\Models\nivelmodel;
use App\Models\apoderadomodel;
use App\Models\exportarcurso;
use CodeIgniter\Controller;

class Cursos extends Controller
{
    private $cursodata;
    private $cursodata;
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
        $this->cursodata = new exportarcurso();
        $this->asignaturaModel = new AsignaturaModel();
        $this->asignaturaCursoModel = new AsignaturaCursoModel();
        $this->cursodata = new exportarcurso();
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
    }    public function editar($id)
    {
        $data['curso'] = $this->cursoModel->obtenerCursoPorId($id);
        $data['asignaturas'] = $this->asignaturaModel->obtenerAsignaturas($id);
        $data['usuarios'] = $this->crudUsuarioModel->obtenerUsuarios();
        $data['niveles'] = $this->nivelModel->obtenerNiveles();
        if (!$id) {
            return redirect()->to(site_url('cursos'))->with('error', 'El curso no existe.');
        }
        return view('Components/edit', $data);
        return view('Components/edit', $data);
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
        $nivelModel = new nivelmodel();
        $asignaturaModel = new asignaturamodel();
        $usuarioModel = new crudusuariomodel();
        $nivelModel = new nivelmodel();
        $asignaturaModel = new asignaturamodel();
        $usuarioModel = new crudusuariomodel();

        $data['niveles'] = $nivelModel->findAll();
        $data['asignaturas'] = $asignaturaModel->findAll();
        $data['usuarios'] = $usuarioModel->findAll();

        return view('Components/agregar', $data);
        return view('Components/agregar', $data);
    } 
    public function exportarcurso($cursoId) {
      
        $data = $this->cursodata->obtenerDatosGenerales($cursoId);

       
        return $this->response->setJSON($data);
        
    }
    public function exportarasistencias(){
        $asistencias = $this->asistenciasmodel->obtenerAsistencias();

        // Verificar si se encontraron asistencias
        if (empty($asistencias)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No se encontraron asistencias registradas.'
            ]);
        }
        
        // Crear el contenido para PDFMake
        $pdf_data = [
            'header' => ['Curso', 'Mes', 'Fecha', 'Estudiante', 'Asistencia'],
            'body' => []
        ];
        
        $current_curso = '';
        $current_mes = '';
        
        foreach ($asistencias as $asistencia) {
            // Si necesitas agregar lógica para organizar por curso o mes
            $curso = $asistencia['nombre_curso'];
            $mes = date('Y-m', strtotime($asistencia['fecha'])); // Obtener mes en formato "2024-12"
        
            // Organizar datos por curso y mes (opcional)
            if ($curso !== $current_curso || $mes !== $current_mes) {
                $current_curso = $curso;
                $current_mes = $mes;
                $pdf_data['body'][] = [
                    "Curso: $curso", "Mes: $mes", '', '', '' // Títulos intermedios
                ];
            }
            $estado_asistencia = $asistencia['estado_asistencia'] == 1 ? 'Presente' : 'Ausente';

            // Agregar datos al cuerpo
            $pdf_data['body'][] = [
                $curso,
                $mes,
                $asistencia['fecha'],
                $asistencia['nombre_estudiante'],
                $estado_asistencia
            ];
        }
        
        // Enviar datos JSON para PDFMake
        return $this->response->setJSON([
            'success' => true,
            'pdf_data' => $pdf_data
        ]);

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
       
        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data);
        }
   
        // Si no es AJAX, retornar la vista
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
         if ($this->cursoModel->eliminarCurso($id)) {
        return redirect()->to('cursos')->with('success', 'Curso borrado correctamente.');
    } else {
        return redirect()->to('cursos')->with('error', 'No se pudo borrar el curso.');
    }
    }
}
