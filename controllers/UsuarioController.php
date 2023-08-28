<?php

namespace Controllers;
use Exception;
use Model\Usuario;
use Model\Rol;
use Model\Asignacion;
use MVC\Router;

class UsuarioController{
    public static function index(Router $router) {
        $usuario = Usuario::all();
        $router->render('usuarios/index', [

        ]);
  
       
    }
    public static function datatable(Router $router){ 
        $asignaciones = static::buscarAsignacion(); 
        $roles = static::buscarRol(); 
        $usuarios = Usuario::all(); 
 
        $router->render('usuarios/datatable', [ 
            'asignaciones' => $asignaciones, 
            'roles' => $roles, 
            'usuarios' => $usuarios, 
        ]); 
    } 
    public static function buscarAsignacion(){ 
        $sql = "SELECT * FROM permiso where permiso_situacion = 1"; 
     
        try { 
            $asignaciones = Asignacion::fetchArray($sql); 
     
            return $asignaciones; 
        } catch (Exception $e) { 
 
            return []; 
             
        } 
    } 
    //!-------------------------- 
    public static function buscarRol(){ 
        $sql = "SELECT * FROM rol where rol_situacion = 1"; 
     
        try { 
            $roles = Rol::fetchArray($sql); 
            return $roles; 
 
        } catch (Exception $e) { 
            return []; 
             
        } 
    }

    public static function guardarApi() {
        try {
           
            $contrasenia = $_POST['usu_password'];
          
            $contraseniaHasheada = password_hash($contrasenia, PASSWORD_DEFAULT);
             
            $_POST['usu_password'] = $contraseniaHasheada;
               
            $usuario = new Usuario($_POST);
              
            $resultado = $usuario->crear();
    
            if ($resultado['resultado'] == 1) {
                echo json_encode([
                    'mensaje' => 'Registro guardado correctamente',
                    'codigo' => 1
                ]);
            } else {
                echo json_encode([
                    'mensaje' => 'Ocurrió un error',
                    'codigo' => 0
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'detalle' => $e->getMessage(),
                'mensaje' => 'Ocurrió un error',
                'codigo' => 0
            ]);
        }
    }
    public static function buscarAPI() 
    { 
        $usu_id = $_GET['usu_id']; 
        $rol_id = $_GET['rol_id']; 
        $permiso_usuario = $_GET['permiso_usuario'];  
        $permiso_rol = $_GET['permiso_rol'];  
 
        $sql = "SELECT 
        h.permiso_id, 
        u.usu_nombre AS permiso_usuario, 
        u.usu_id, 
        u.usu_password, 
        r.rol_nombre AS permiso_rol, 
        r.rol_id, 
        u.usu_situacion 
    FROM 
        permiso h 
    INNER JOIN 
        usuario u ON h.permiso_usuario = u.usu_id 
    INNER JOIN 
        rol r ON h.permiso_rol = r.rol_id 
    WHERE 
        p.permiso_situacion = 1;"; 
     
    if ($usu_id != '') { 
        $sql .= " AND usuario.usu_id = '$usu_id'"; 
    } 
     
    if ($rol_id != '') { 
        $sql .= " AND rol.rol_id = '$rol_id'"; 
    } 
    if ($permiso_usuario != '') { 
        $permiso_usuario = strtolower($permiso_usuario); 
        $sql .= " AND LOWER(permiso_usuario) LIKE '%$permiso_usuario%' "; 
    } 
    if ($permiso_rol != '') { 
        $permiso_rol = strtolower($permiso_rol); 
        $sql .= " AND permiso_rol= '$permiso_rol' "; 
    } 
 
        try { 
 
            $permisos = Usuario::fetchArray($sql); 
 
            echo json_encode($permisos); 
        } catch (Exception $e) { 
            echo json_encode([ 
                'detalle' => $e->getMessage(), 
                'mensaje' => 'Ocurrió un error', 
                'codigo' => 0 
            ]); 
        } 
    }
    public static function estadistica(Router $router){ 
        $router->render('usuarios/estadistica', []); 
    } 
 
    public static function detalleUsuarioRolAPI(){ 
 
        $sql = "SELECT r.rol_nombre AS rol, COUNT(h.permiso_id) AS cantidad_usuarios 
        FROM rol r 
        LEFT JOIN permiso h ON r.rol_id = p.permiso_rol 
        GROUP BY r.rol_id, r.rol_nombre 
        ORDER BY r.rol_nombre;"; 
                 
        try { 
             
            $usuarios = Usuario::fetchArray($sql); 
     
            echo json_encode($usuarios); 
        } catch (Exception $e) { 
            echo json_encode([ 
                'detalle' => $e->getMessage(), 
                'mensaje' => 'Ocurrió un error', 
                'codigo' => 0 
            ]); 
        } 
    }

}
 
?>