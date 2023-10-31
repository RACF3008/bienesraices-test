<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController {

    public static function index(Router $router) {

        // Consulta para obtener propiedades
        $propiedades = Propiedad::all();

        // Consulta para obtener vendedores
        $vendedores = Vendedor::all();

        // Muestra el mensaje condicional
        $resultado = $_GET['resultado'] ?? null;
        
        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'vendedores' => $vendedores,
            'resultado' => $resultado
        ]);
    }

    public static function crear(Router $router) {

        // Nueva instancia de Propiedad
        $propiedad = new Propiedad;

        // Consulta para obtener vendedores
        $vendedores = Vendedor::all();

        // Arreglo de errores
        $errores = Propiedad::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Nueva instancia de Propiedad
            $propiedad = new Propiedad($_POST['propiedad']);

            // Generar nombre para la imagen
            $nombreImagen = md5( uniqid( rand(), true ) ) . '.jpg';

            // Resize a la imagen con Intervention
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }

            $errores = $propiedad->validar();

            // Revisar por errores
            if (empty($errores)) {

                // Crear carpeta de imagenes
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }

                // Guardar imagen en la DB
                $image->save(CARPETA_IMAGENES . $nombreImagen);

                // Guardamos la propiedad
                $propiedad->guardar();
            }
        }
        
        // Enviar lista para la creacion de variables
        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router) {
        
        // Verificar que el ID sea valido
        $id = validarORedireccionar('/admin');

        // Obtener la propiedad a actualizar
        $propiedad = Propiedad::find($id);

        // Consulta para obtener vendedores
        $vendedores = Vendedor::all();

        // Arreglo de errores
        $errores = Propiedad::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Asignar los atributos
            $args = $_POST['propiedad'];
    
            $propiedad->sincronizar($args);
    
            // Validacion
            $errores = $propiedad->validar();
    
            // Generar nombre para la imagen
            $nombreImagen = md5( uniqid( rand(), true ) ) . '.jpg';
    
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }
    
            // Revisar por errores
            if (empty($errores)) {
    
                // Almacenar imagen en el servidor
                if ($_FILES['propiedad']['tmp_name']['imagen']) {
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }
                $resultado = $propiedad->guardar();
            }
        }

        $router->render('propiedades/actualizar', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function eliminar(Router $router) {
        
        // Si se realiza una peticion de tipo POST...
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            // Validar el tipo de contenido
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {
                $tipo = $_POST['tipo'];

                if (validarTipoContenido($tipo)) {

                    // Buscar la propiedad a eliminar
                    $propiedad = Propiedad::find($id);

                    // Eliminar la propiedad
                    $propiedad->eliminar();
                }
            }
        }
    }
}