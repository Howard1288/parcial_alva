<?php

namespace Controllers;

use Exception;
use Model\Detalle;
use Model\Usuario;
use MVC\Router;

class DetalleController
{
    public static function index(Router $router) {
        $usuario = Usuario::all();
        $router->render('usuarios/estadistica', [
            'usuarios' => $usuario,
        ]);
  
       
    }

    public static function detalleUsuarioAPI()
    {

        $sql = "SELECT * FROM usuario ";

        try {

            $detalles = Detalle::fetchArray($sql);

            echo json_encode($detalles);
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
}