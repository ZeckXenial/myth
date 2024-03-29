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

$routes->get('anotaciones/curso/(:num)', 'Anotaciones::curso/$1');
$routes->get('asistencias/curso/(:num)', 'Asistencias::curso/$1');
$routes->get('calificaciones/(:num)/(:num)', 'Calificaciones::calificaciones/$1/$1');

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
$routes->post('calificaciones/guardar', 'Calificaciones::guardar');
$routes->get('editar/(:num)', 'Calificaciones::editar/$1');
$routes->post('calificacion/update/(:num)', 'Calificaciones::update/$1');
$routes->get('delete/(:num)', 'Calificaciones::delete/$1');



$routes->get('estudiantes', 'crudEstudiantes::index');
$routes->post('estudiantes', 'crudEstudiantes::editar/$1');
$routes->get('estudiantes/agregar', 'crudEstudiantes::agregar');
$routes->post('estudiantes/agregar', 'crudEstudiantes::agregar');
$routes->get('estudiantes/editar/(:num)', 'crudEstudiantes::editar/$1');
$routes->post('estudiantes/editar/(:num)', 'crudEstudiantes::editar/$1');
$routes->post('eliminar/(:num)', 'crudEstudiantes::eliminar/$1');

$routes->post('crud_usuarios/agregar', 'CrudUsuariosController::agregar');
$routes->get('crud_usuarios/eliminar/(:num)', 'CrudUsuariosController::eliminar/$1');
$routes->get('crud_usuarios', 'CrudUsuariosController::index');
$routes->post('crud_usuarios/editar/(:num)', 'CrudUsuariosController::editar/$1');

$routes->post('auth/submit_login', 'Auth::submit_login');
$routes->get('dashboard', 'DashboardController::index');
