<?php
$pretionAjax = true;
require_once "../nucleo/configGeneral.php";

if(isset($_POST['dni-reg'])){
    require_once "../controladores/administradorControlador.php";
    $insAdmin = new administradorControlador();

    //Validando si los campos viene llenos para poder realizar el registro del administrador.
    if(isset($_POST['dni-reg']) && isset($_POST['nombre-reg']) && isset($_POST['apellido-reg']) && isset($_POST['usuario-reg']))  {

        echo $insAdmin->agregar_administrador_controlador();
        
    }

}else{
    session_start();
    session_destroy();
    echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
}