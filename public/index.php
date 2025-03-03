<?php 
require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AppController;
use Controllers\UsuarioController;
use Controllers\AsignacionController;
use Controllers\DetalleController;

use Model\Usuario;

$router = new Router();
$router->setBaseURL('/' . $_ENV['APP_NAME']);

$router->get('/', [AppController::class,'index']);

$router->get('/usuarios', [UsuarioController::class,'index']);
$router->post('/API/usuarios/guardar', [UsuarioController::class,'guardarApi']);

$router->get('/asignaciones', [AsignacionController::class,'index']);
$router->get('/API/asignaciones/buscar', [AsignacionController::class,'buscarApi']);
$router->post('/API/asignaciones/guardar', [AsignacionController::class,'guardarApi']);
$router->post('/API/asignaciones/modificar', [AsignacionController::class,'modificarApi']);
$router->post('/API/asignaciones/eliminar', [AsignacionController::class,'eliminarAPI']);


//estadistica

$router->get('/usuarios/estadistica', [UsuarioController::class,'estadistica']);
$router->get('/API/usuarios/estadistica', [UsuarioController::class,'detalleUsuarioRolAPI']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();