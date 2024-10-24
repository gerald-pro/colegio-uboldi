<?php
require_once "controladores/PlantillaControlador.php";
require_once "controladores/ApoderadoControlador.php";
require_once "controladores/CursoControlador.php";
require_once "controladores/CuotaControlador.php";
require_once "controladores/PagoControlador.php";
require_once "controladores/UsuarioControlador.php";
require_once "controladores/Estudiantecontrolador.php";

require_once "modelos/Apoderado.php";
require_once "modelos/Curso.php";
require_once "modelos/Cuota.php";
require_once "modelos/MetodoPago.php";
require_once "modelos/Pago.php";
require_once "modelos/DetallePago.php";
require_once "modelos/Usuario.php";
require_once "modelos/Estudiante.php";
date_default_timezone_set('America/La_Paz');

$plantilla=new PlantillaControlador();
$plantilla->ctrPlantilla();

