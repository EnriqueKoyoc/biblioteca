<?php
require_once "./modelos/vistasModelo.php";
class vistasControlador extends vistasModelo{

    public function obtener_plantilla_controlador(){
        return require_once "./vistas/plantilla.php";
    }

    // function que sirve para mostrar la vista de acuerdo el valor proporcioando
    public function obtener_vistas_controlador(){
        if(isset($_GET['views'])){
            $ruta = explode("/", $_GET['views']);
            $respuesta = vistasModelo::obtener_vistas_modelo($ruta[0]);
        }else{
            $respuesta = "login";
        }
        return $respuesta;
    }

}