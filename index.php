<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once "controllers/rutas.controlador.php";
require_once "controllers/categorias.controlador.php";
require_once "controllers/clientes.controlador.php";
require_once "controllers/productos.controlador.php";
require_once "models/clientes.modelo.php";
require_once "models/categorias.modelo.php";
require_once "models/productos.modelo.php";

$rutas = new ControladorRutas();
$rutas->Inicio();
