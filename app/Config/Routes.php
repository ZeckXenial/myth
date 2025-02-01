<?php
use CodeIgniter\Router\RouteCollection;
/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('login', 'Home::login');
$routes->get('teacher/dashboard', 'TeacherController::dashboard');
$routes->get('admin/dashboard', 'TeacherController::admin');
$routes->get('logout', 'Auth::logout');

$routes->get('cursos', 'CursosController::index');
$routes->get('editar/(:num)', 'Asignaturas::editar/$1');
$routes->post('asignaturas/crear', 'Asignaturas::crear');
$routes->get('asignaturas/agregar', 'Asignaturas::asignaturas');
$routes->post('asignaturas/editar/(:num)', 'Asignaturas::editar/$1');
$routes->post('asignaturas/eliminar/(:num)', 'Asignaturas::eliminar/$1');

$routes->get('check-session', 'SessionController::check');

$routes->get('anotaciones/curso/(:num)', 'Anotaciones::curso/$1');
$routes->get('asistencias/curso/(:num)', 'Asistencias::curso/$1');
$routes->get('calificaciones/(:num)/(:num)', 'Calificaciones::calificaciones/$1/$2');
$routes->get('calificaciones/(:num)/(:num)', 'Calificaciones::calificaciones/$1/$2');

$routes->get('usuario/mi_informacion', 'CrudUsuariosController::miInformacion');
$routes->post('usuario/actualizar_informacion', 'CrudUsuariosController::actualizarInformacion');
$routes->get('usuario/mi_informacion', 'CrudUsuariosController::miInformacion');

$routes->get('notas', 'NotasController::index');
$routes->get('notas/crud/(:num)', 'NotasController::crud/$1');

$routes->post('guardar_asistencias/(:num)', 'Asistencias::ingresarAsistencias/$1');
$routes->post('anotaciones/crear', 'Anotaciones::crear');
$routes->post('anotaciones/editar/(:num)', 'Anotaciones::editar/$1');
$routes->post('anotaciones/editar/(:num)', 'Anotaciones::editar/$1');
$routes->get('eliminar/(:num)', 'Anotaciones::eliminar/$1');

$routes->post('exportar', 'Exportar::index');

$routes->get('cursos/agregar', 'Cursos::agregar');
$routes->post('cursos/guardar', 'Cursos::guardar');
$routes->get('cursos/exportar/(:num)', 'Cursos::exportar/$1');
$routes->get('cursos/exportarestudiante/(:num)', 'Cursos::exportarestudiante/$1');
$routes->post('cursos/exportarestudiante/(:num)', 'Cursos::exportarestudiante/$1');
$routes->get('cursos/editar/(:num)', 'Cursos::editar/$1');
$routes->post('cursos/update/(:num)', 'Cursos::update/$1');
$routes->get('cursos/delete/(:num)', 'Cursos::delete/$1');

$routes->get('actividad/vista/(:num)/(:num)', 'actividad::mostrarActividadesRecientes/$1/$2');
$routes->get('actividad/formulario/(:num)/(:num)', 'actividad::mostrarFormulario/$1/$2');
$routes->post('actividad/registrarActividad', 'actividad::registrarActividad');
$routes->post('valuaciones/agregarEvaluacion', 'Calificaciones::agregarEvaluacion');
$routes->get('evaluaciones/agregarEvaluacion', 'Calificaciones::agregarEvaluacion');
$routes->get('evaluaciones/guardarNota','Calificaciones::guardarnota');
$routes->post('valuaciones/agregarEvaluacion', 'Calificaciones::agregarEvaluacion');
$routes->get('evaluaciones/agregarEvaluacion', 'Calificaciones::agregarEvaluacion');
$routes->get('evaluaciones/guardarNota','Calificaciones::guardarnota');

$routes->get('/', 'Calificaciones::index');
$routes->get('calificaciones/asignaturas/(:num)', 'Calificaciones::asignaturas/$1');
$routes->post('calificaciones/guardar', 'Calificaciones::guardar');
$routes->get('editar/(:num)', 'Calificaciones::editar/$1');
$routes->post('calificacion/update/(:num)', 'Calificaciones::update/$1');
$routes->get('delete/(:num)', 'Calificaciones::delete/$1');

$routes->get('api/verify-otp', 'otpcontroller::verifyotp');

$routes->get('estadisticas','estadisticas::index');

$routes->get('matriculas','matriculas::index');
$routes->post('matriculas/guardar', 'matriculas::guardar');
$routes->get('matriculas/editar/(:num)/(:num)/(:num)', 'matriculas::editar/$1/$2/$3');
$routes->post('matriculas/actualizar/(:num)/(:num)/(:num)', 'matriculas::actualizar/$1/$2/$3');
$routes->get('matriculas/eliminar/(:num)', 'matriculas::eliminar/$1');
$routes->get('matriculas/guardar', 'matriculas::guardar');
$routes->get('cursos/exportarcurso/(:num)', 'cursos::exportarcurso/$1');
$routes->get('cursos/exportarasistencias','cursos::exportarasistencias');
$routes->get('cursos/exportarasistencias','cursos::exportarasistencias');

$routes->get('estudiantes', 'matriculas::index');
$routes->post('estudiantes', 'crudEstudiantes::editar/$1');
$routes->get('estudiantes/agregar', 'crudEstudiantes::agregar');
$routes->post('estudiantes/agregar', 'crudEstudiantes::agregar');
$routes->get('estudiantes/editar/(:num)', 'crudEstudiantes::editar/$1');
$routes->post('estudiantes/editar/(:num)', 'crudEstudiantes::editar/$1');
$routes->post('estudiantes/eliminar/(:num)', 'crudestudiantes::eliminar/$1');

$routes->post('crud_usuarios/agregar', 'CrudUsuariosController::agregar');
$routes->get('crud_usuarios/eliminar/(:num)', 'CrudUsuariosController::eliminar/$1');
$routes->get('usuarios', 'CrudUsuariosController::index');
$routes->post('crud_usuarios/editar/(:num)', 'CrudUsuariosController::editar/$1');

$routes->post('auth', 'Auth::submit_login');
$routes->get('dashboard', 'DashboardController::index');

$routes->get('calendar', 'CalendarController::index'); // Ruta para la vista del calendario
$routes->get('calendar/getEvents', 'CalendarController::getEvents'); // Ruta para obtener eventos
$routes->post('calendar/addEvent', 'CalendarController::addEvent'); // Ruta para agregar eventos

$routes->get('calendar', 'CalendarController::index'); // Ruta para la vista del calendario
$routes->get('calendar/getEvents', 'CalendarController::getEvents'); // Ruta para obtener eventos
$routes->post('calendar/addEvent', 'CalendarController::addEvent'); // Ruta para agregar eventos

$routes->get('cursos', 'CursosController::index');
$routes->get('editar/(:num)', 'Asignaturas::editar/$1');
$routes->post('asignaturas/crear', 'Asignaturas::crear');
$routes->get('asignaturas/agregar', 'Asignaturas::asignaturas');
$routes->post('asignaturas/editar/(:num)', 'Asignaturas::editar/$1');
$routes->post('asignaturas/eliminar/(:num)', 'Asignaturas::eliminar/$1');

$routes->get('check-session', 'SessionController::check');

$routes->get('anotaciones/curso/(:num)', 'Anotaciones::curso/$1');
$routes->get('asistencias/curso/(:num)', 'Asistencias::curso/$1');
$routes->get('calificaciones/(:num)/(:num)', 'Calificaciones::calificaciones/$1/$1');

$routes->get('usuario/mi_informacion', 'CrudUsuariosController::miInformacion');
$routes->post('usuario/actualizar_informacion', 'CrudUsuariosController::actualizarInformacion');
$routes->get('usuario/mi_informacion', 'CrudUsuariosController::miInformacion');

$routes->get('notas', 'NotasController::index');
$routes->get('notas/crud/(:num)', 'NotasController::crud/$1');

$routes->post('guardar_asistencias/(:num)', 'Asistencias::ingresarAsistencias/$1');
$routes->post('anotaciones/crear', 'Anotaciones::crear');
$routes->post('editar/(:num)', 'Anotaciones::editar/$1');
$routes->get('eliminar/(:num)', 'Anotaciones::eliminar/$1');

$routes->post('exportar', 'Exportar::index');

$routes->get('cursos/agregar', 'Cursos::agregar');
$routes->post('cursos/guardar', 'Cursos::guardar');
$routes->get('cursos/exportar/(:num)', 'Cursos::exportar/$1');
$routes->get('cursos/exportarestudiante/(:num)', 'Cursos::exportarestudiante/$1');
$routes->post('cursos/exportarestudiante/(:num)', 'Cursos::exportarestudiante/$1');
$routes->get('cursos/editar/(:num)', 'Cursos::editar/$1');
$routes->post('cursos/update/(:num)', 'Cursos::update/$1');
$routes->get('cursos/delete/(:num)', 'Cursos::delete/$1');

$routes->get('actividad/formulario/(:num)/(:num)', 'actividad::mostrarFormulario/$1/$2');
$routes->post('actividad/registrarActividad', 'actividad::registrarActividad');
$routes->post('evaluaciones/agregarEvaluacion', 'Calificaciones::agregarEvaluacion');
$routes->get('evaluaciones/agregarEvaluacion', 'Calificaciones::agregarEvaluacion');
$routes->get('evaluaciones/guardarNota','Calificaciones::guardarnota');
$routes->post('evaluaciones/agregarEvaluacion', 'Calificaciones::agregarEvaluacion');
$routes->get('evaluaciones/agregarEvaluacion', 'Calificaciones::agregarEvaluacion');
$routes->get('evaluaciones/guardarNota','Calificaciones::guardarnota');

$routes->get('/', 'Calificaciones::index');
$routes->get('calificaciones/obtenerCalificaciones/(:num)/(:num)','Calificaciones::obtenerCalificaciones/$2/$1');
$routes->get('calificaciones/obtenerCalificaciones/(:num)/(:num)','Calificaciones::obtenerCalificaciones/$2/$1');
$routes->get('calificaciones/asignaturas/(:num)', 'Calificaciones::asignaturas/$1');
$routes->post('calificaciones/guardar', 'Calificaciones::guardar');
$routes->get('editar/(:num)', 'Calificaciones::editar/$1');
$routes->post('calificacion/update/(:num)', 'Calificaciones::update/$1');
$routes->get('delete/(:num)', 'Calificaciones::delete/$1');

$routes->get('api/verify-otp', 'otpcontroller::verifyotp');

$routes->get('calendar/getEvents', 'CalendarController::getEvents'); // Ruta para obtener eventos

$routes->get('calendar/getEvents', 'CalendarController::getEvents'); // Ruta para obtener eventos

$routes->get('estadisticas','estadisticas::index');

$routes->get('matriculas','matriculas::index');
$routes->post('matriculas/guardar', 'matriculas::guardar');
$routes->get('matriculas/editar/(:num)/(:num)/(:num)', 'matriculas::editar/$1/$2/$3');
$routes->post('matriculas/actualizar/(:num)/(:num)/(:num)', 'matriculas::actualizar/$1/$2/$3');
$routes->get('matriculas/eliminar/(:num)', 'matriculas::eliminar/$1');
$routes->get('matriculas/guardar', 'matriculas::guardar');
$routes->get('cursos/exportarcurso/(:num)', 'Cursos::exportar/$1');

$routes->get('estudiantes', 'matriculas::index');
$routes->post('estudiantes', 'crudEstudiantes::editar/$1');
$routes->get('estudiantes/agregar', 'crudEstudiantes::agregar');
$routes->post('estudiantes/agregar', 'crudEstudiantes::agregar');
$routes->get('estudiantes/editar/(:num)', 'crudEstudiantes::editar/$1');
$routes->post('estudiantes/editar/(:num)', 'crudEstudiantes::editar/$1');
$routes->post('estudiantes/eliminar/(:num)', 'crudestudiantes::eliminar/$1');

$routes->post('crud_usuarios/agregar', 'CrudUsuariosController::agregar');
$routes->get('crud_usuarios/eliminar/(:num)', 'CrudUsuariosController::eliminar/$1');
$routes->get('usuarios', 'CrudUsuariosController::index');
$routes->post('crud_usuarios/editar/(:num)', 'CrudUsuariosController::editar/$1');

$routes->post('auth', 'Auth::submit_login');
$routes->get('dashboard', 'DashboardController::index');

$routes->post('calendar/editEvent/(:num)', 'CalendarController::editEvent/$1');$routes->post('evento/agregar', 'EventoController::addEvent');
$routes->get('calendar', 'CalendarController::index');
$routes->get('calendar/getEvents', 'CalendarController::getEvents');
$routes->delete('calendar/deleteEvent/(:num)', 'CalendarController::deleteEvent/$1');

$routes->post('calendar/editEvent/(:num)', 'CalendarController::editEvent/$1');$routes->post('evento/agregar', 'EventoController::addEvent');
$routes->get('calendar', 'CalendarController::index');
$routes->get('calendar/getEvents', 'CalendarController::getEvents');
$routes->delete('calendar/deleteEvent/(:num)', 'CalendarController::deleteEvent/$1');

$routes->get('horarios', 'HorarioClaseController::listarHorarios'); // Listar horarios
$routes->get('horarios/crear', 'HorarioClaseController::crearHorario'); // Crear nuevo horario
$routes->post('horarios/crear', 'HorarioClaseController::crearHorario'); // Enviar formulario para crear horario
$routes->get('horarios/editar/(:num)', 'HorarioClaseController::editarHorario/$1'); // Editar horario
$routes->post('horarios/editar/(:num)', 'HorarioClaseController::editarHorario/$1'); // Enviar formulario para editar horario
$routes->get('horarios/eliminar/(:num)', 'HorarioClaseController::eliminarHorario/$1'); 
$routes->get('horarios/getAsignaturasPorProfesor/(:num)', 'HorarioClaseController::getAsignaturasPorProfesor/$1');// Eliminar horario