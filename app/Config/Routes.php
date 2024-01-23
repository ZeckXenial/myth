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

$routes->get('establecimientos', 'Directive::establecimientos');

$routes->get('anotaciones/curso/(:num)', 'Anotaciones::curso/$1');
$routes->get('asistencias/curso/(:num)', 'Asistencias::curso/$1');
$routes->get('calificaciones/curso/(:num)', 'Calificaciones::curso/$1');

$routes->get('notas', 'NotasController::index');
$routes->get('notas/crud/(:num)', 'NotasController::crud/$1');

$routes->get('asistencia', 'Crudasistencias::index');
$routes->post('asistencia/agregar', 'Crudasistencias::agregar');
$routes->post('asistencia/editar/(:any)', 'Crudasistencias::editar/$1');
$routes->get('asistencia/eliminar/(:any)', 'Crudasistencias::eliminar/$1');

$routes->post('components/crud_usuarios/agregar', 'CrudUsuariosController::agregar');
$routes->add('crud_usuarios', 'CrudUsuariosController::index');
$routes->post('components/crud_usuarios/editar/(:segment)', 'CrudUsuariosController::editar/$1');
$routes->add('crud_apoderados', 'Crudapoderados::index');
$routes->post('auth/submit_login', 'Auth::submit_login');
$routes->get('dashboard', 'DashboardController::index');
$routes->post('components/crud_apoderados/agregar', 'CrudApoderados::agregar');
$routes->post('components/crud_apoderados/editar/(:segment)', 'CrudApoderados::editar/$1');
$routes->get('components/crud_apoderados/eliminar/(:segment)', 'CrudApoderados::eliminar/$1');


