<?php

require_once "controllers/plantilla.controlador.php";
require_once "controllers/blog.controlador.php";

require_once "controllers/correo.controlador.php";
require_once "models/blog.modelo.php";

require 'extensiones/vendor/autoload.php';

$plantilla = new ControladorPlantilla();
$plantilla -> ctrTraerPlantilla();
