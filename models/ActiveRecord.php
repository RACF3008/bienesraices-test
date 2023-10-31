<?php

namespace Model;

class ActiveRecord {
    // Base de datos
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

    // Errores
    protected static $errores = [];

    public static function setDB($database) {
        self::$db = $database;
    }

    public function guardar() {
        if(!is_null($this->id)) {
            $this->actualizar();
        } else {
            $this->crear();
        }
    }

    public function crear() {

        //Sanitizar los datos
        $atributos = $this->sanitizar();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla ." ( ";
        $query .= join(', ', array_keys($atributos));
        $query .=" ) VALUES ( '";
        $query .= join("', '", array_values($atributos));
        $query .= "' ) ";

        $resultado = self::$db->query($query);

        if ($resultado) {
            // Redireccionar al usuario

            header('Location: /admin?resultado=1');
        }
    }

    public function actualizar() {

        //Sanitizar los datos
        $atributos = $this->sanitizar();

        // Creacion de query para actualizar
        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key} = '{$value}'";
        }

        $query = " UPDATE " . static::$tabla ." SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        // Actualizar la base de datos
        $resultado = self::$db->query($query);

        if ($resultado) {
            // Redireccionar al usuario

            header('Location: /admin?resultado=2');
        }
    }

    public function eliminar() {
        $query = " DELETE FROM " . static::$tabla ." WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1 ";
        $resultado = self::$db->query($query);

        if($resultado) {
            $this->borrarImagen();
            header("Location: /admin?resultado=3");
        }
    }

    public function atrbiutos() {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizar() {
        $atributos = $this->atrbiutos();
        $sanitizado = [];

        // Sanitizar los datos
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    // Subir imagenes
    public function setImagen($imagen) {

        // Elimina la imagen anterior
        if(!is_null($this->id)) {
            // Borrar imagen
            $this->borrarImagen();
        }

        // Asignar imagen
        if($imagen) {
            $this->imagen = $imagen;
        }
    }

    // Eliminar imagen
    public function borrarImagen() {

        // Eliminar imagen del servidor
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    // Validacion
    public static function getErrores() {

        return static::$errores;
    }

    public function validar() {
        static::$errores = [];
        
        return static::$errores;
    }

    // Lista todos los registros
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // Obtener cierta cantidad de registros
    public static function get($cantidad) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // Buscar un registro por su ID
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla ." WHERE id = ${id}";

        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }

    public static function consultarSQL($query) {
        // Consultar la Base de Datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while ($propiedad = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($propiedad);
        }

        // Liberar la memoria
        $resultado->free();

        // Devolver los resultados
        return $array;

    }

    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value) {
            if(property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }
    // Sincroniza el objeto volatil con el objeto de la base de datos
    public function sincronizar($args = []) {
        foreach($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}