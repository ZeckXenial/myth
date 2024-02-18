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

$routes->get('cursos/agregar', 'Cursos::agregar');
$routes->post('cursos/guardar', 'Cursos::guardar');
$routes->get('cursos/editar/(:num)', 'Cursos::editar/$1');
$routes->post('cursos/update/(:num)', 'Cursos::update/$1');
$routes->get('cursos/delete/(:num)', 'Cursos::delete/$1');

$routes->get('/', 'EstudiantesController::index');
    $routes->get('agregar', 'EstudiantesController::agregar');
    $routes->post('agregar', 'EstudiantesController::agregar');
    $routes->get('editar/(:num)', 'EstudiantesController::editar/$1');
    $routes->post('editar/(:num)', 'EstudiantesController::editar/$1');
    $routes->get('eliminar/(:num)', 'EstudiantesController::eliminar/$1');

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
