<?php
$pretionAjax = true;
require_once "../nucleo/configGeneral.php";

if(isset($_GET['Token'])){
    require_once "../controladores/loginControlador.php";
    $logoout = new loginControlador();
    echo $logoout->cerrar_sesion_controlador(); 

}else{
    session_start();
    session_destroy();
    echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
}