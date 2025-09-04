<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('personas/listar', 'PersonaController::listar');
$routes->get('personas/crear', 'PersonaController::crear');
$routes->post('personas/guardar', 'PersonaController::guardar');
$routes->get('personas/editar/(:num)', 'PersonaController::editar/$1');
$routes->post('personas/actualizar', 'PersonaController::actualizar');
$routes->get('personas/borrar/(:num)', 'PersonaController::borrar/$1');

$routes->get('usuarios/listar', 'UsuarioController::listar');
$routes->get('usuarios/crear', 'UsuarioController::crear');
$routes->post('usuarios/guardar', 'UsuarioController::guardar');
$routes->get('usuarios/editar/(:num)', 'UsuarioController::editar/$1');
$routes->post('usuarios/actualizar/(:num)', 'UsuarioController::actualizar/$1');
$routes->get('usuarios/borrar/(:num)', 'UsuarioController::borrar/$1');

$routes->get('calendarizaciones/listar', 'CalendarizacionController::listar');
$routes->get('calendarizaciones/crear', 'CalendarizacionController::crear');
$routes->post('calendarizaciones/guardar', 'CalendarizacionController::guardar');
$routes->get('calendarizaciones/editar/(:num)', 'CalendarizacionController::editar/$1');
$routes->post('calendarizaciones/actualizar', 'CalendarizacionController::actualizar');
$routes->get('calendarizaciones/borrar/(:num)', 'CalendarizacionController::borrar/$1');

$routes->get('grupos/listar', 'GrupoController::listar');
$routes->get('grupos/crear', 'GrupoController::crear');
$routes->post('grupos/guardar', 'GrupoController::guardar');
$routes->get('grupos/editar/(:num)', 'GrupoController::editar/$1');
$routes->post('grupos/actualizar/(:num)', 'GrupoController::actualizar/$1');
$routes->get('grupos/borrar/(:num)', 'GrupoController::borrar/$1'); 

$routes->get('matriculas/listar', 'MatriculaController::listar');
$routes->get('matriculas/crear', 'MatriculaController::crear');
$routes->post('matriculas/guardar', 'MatriculaController::guardar');
$routes->get('matriculas/editar/(:num)', 'MatriculaController::editar/$1');
$routes->post('matriculas/actualizar/(:num)', 'MatriculaController::actualizar/$1');
$routes->get('matriculas/borrar/(:num)', 'MatriculaController::borrar/$1');

$routes->get('asistencias/listar', 'AsistenciaController::listar');
$routes->get('asistencias/tomar/(:num)', 'AsistenciaController::tomar/$1'); 
$routes->get('asistencias/tomar', 'AsistenciaController::tomar'); 
$routes->post('asistencias/guardar', 'AsistenciaController::guardar');
$routes->get('asistencias/editar/(:num)', 'AsistenciaController::editar/$1');
$routes->post('asistencias/actualizar', 'AsistenciaController::actualizar');
$routes->get('asistencias/borrar/(:num)', 'AsistenciaController::borrar/$1');

$routes->get('/admin', 'AdminController::dashboard');
$routes->get('/admin/login', 'AdminController::login');
$routes->get('/admin/register', 'AdminController::register');










