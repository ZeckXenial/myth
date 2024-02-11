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

$routes->get('asistencia', 'Crudasistencias::index');
$routes->post('asistencia/agregar', 'Crudasistencias::agregar');
$routes->post('asistencia/editar/(:any)', 'Crudasistencias::editar/$1');
$routes->get('asistencia/eliminar/(:any)', 'Crudasistencias::eliminar/$1');

$routes->get('estudiantes', 'CrudEstudiantes::index');
$routes->post('estudiantes/agregar', 'CrudEstudiantes::agregar');
$routes->get('estudiantes/editar/(:num)', 'CrudEstudiantes::editar/$1');
$routes->post('estudiantes/editar/(:num)', 'CrudEstudiantes::editar/$1');
$routes->get('estudiantes/eliminar/(:num)', 'CrudEstudiantes::eliminar/$1');

$routes->post('crud_usuarios/agregar', 'CrudUsuariosController::agregar');
$routes->get('crud_usuarios/eliminar/(:num)', 'CrudUsuariosController::eliminar/$1');
$routes->get('crud_usuarios', 'CrudUsuariosController::index');
$routes->post('crud_usuarios/editar/(:num)', 'CrudUsuariosController::editar/$1');

$routes->post('auth/submit_login', 'Auth::submit_login');
$routes->get('dashboard', 'DashboardController::index');
