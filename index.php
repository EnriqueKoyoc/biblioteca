<?php
require_once "./nucleo/configGeneral.php";
require_once "./controladores/vistasControlador.php";

// mostrar la vista (Se instancia la clase que esta dentro de vistasControlador)
$plantilla = new vistasControlador();
$plantilla->obtener_plantilla_controlador();