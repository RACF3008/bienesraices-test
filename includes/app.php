<?php

use Model\ActiveRecord;
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require 'funciones.php';
require 'config/database.php';

$db = conectarDB();

// Inicializar una conexión estatica a la Base de Datos
ActiveRecord::setDB($db);
