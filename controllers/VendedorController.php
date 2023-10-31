<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;

class VendedorController {

    public static function crear(Router $router) {
        // Nueva instancia de vendedor
        $vendedor = new Vendedor;

        // Arreglo de errores
        $errores = Vendedor::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Crear una instancia nueva de Vendedor
            $vendedor = new Vendedor($_POST['vendedor']);

            // Validar que no hayan campos vacíos
            $errores = $vendedor->validar();

            if(empty($errores)) {

                // Guardamos el vendedor
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/crear', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router) {

        // Validar que el ID del vendedor exista
        $id = validarORedireccionar('/admin');

        // Obtener el vendedor
        $vendedor = Vendedor::find($id);

        // Arreglo de errores
        $errores = Vendedor::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Asignar los atributos
            $args = $_POST['vendedor'];

            // Sincronizar atributos
            $vendedor->sincronizar($args);

            // Validacion
            $errores = $vendedor->validar();

            if (empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/actualizar', [
            'vendedor' => $vendedor,
            'errores' => $errores
        ]);
    }

    public static function eliminar(Router $router) {
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {
                $tipo = $_POST['tipo'];

                if(validarTipoContenido($tipo)) {
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }
            }
        }
    }
}