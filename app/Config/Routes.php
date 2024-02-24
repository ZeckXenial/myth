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

$routes->get('anotaciones/curso/(:num)', 'Anotaciones::curso/$1');
$routes->get('asistencias/curso/(:num)', 'Asistencias::curso/$1');
$routes->get('calificaciones/curso/(:num)', 'Calificaciones::curso/$1');

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

$routes->get('/', 'Calificaciones::index');
$routes->get('calificaciones/asignaturas/(:num)', 'Calificaciones::asignaturas/$1');
$routes->post('guardar', 'Calificaciones::guardar');
$routes->get('editar/(:num)', 'Calificaciones::editar/$1');
$routes->post('update/(:num)', 'Calificaciones::update/$1');
$routes->get('delete/(:num)', 'Calificaciones::delete/$1');

$routes->get('estudiantes', 'crudEstudiantes::index');
$routes->get('estudiantes/agregar', 'EstudiantesController::agregar');
$routes->post('estudiantes/agregar', 'crudEstudiantes::agregar');
$routes->get('editar/(:num)', 'EstudiantesController::editar/$1');
$routes->post('editar/(:num)', 'EstudiantesController::editar/$1');
$routes->get('eliminar/(:num)', 'EstudiantesController::eliminar/$1');


$routes->post('crud_usuarios/agregar', 'CrudUsuariosController::agregar');
$routes->get('crud_usuarios/eliminar/(:num)', 'CrudUsuariosController::eliminar/$1');
$routes->get('crud_usuarios', 'CrudUsuariosController::index');
$routes->post('crud_usuarios/editar/(:num)', 'CrudUsuariosController::editar/$1');

$routes->post('auth/submit_login', 'Auth::submit_login');
$routes->get('dashboard', 'DashboardController::index');
