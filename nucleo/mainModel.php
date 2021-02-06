<?php

if($pretionAjax){
    require_once "../nucleo/configAPP.php";
}else{
    require_once "./nucleo/configAPP.php";
}

class mainModel{

    // funcion para conectar a la base de datos
    protected function conectar(){
        $enlace = new PDO(SGBD, USER, PASS);
        return $enlace;
    }

    protected function ejecutar_consulta_simple($consulta){
        $respuesta=self::conectar()->prepare($consulta); //Viene de la función conectar, esta siendo heredada.
        $respuesta->execute();
        return $respuesta;
    }

    // function agregar cuenta
    protected function agregar_cuenta($datos){
        $sql = self::conectar()->prepare("INSERT INTO cuenta(CuentaCodigo,CuentaPrivilegio,CuentaUsuario,CuentaClave,CuentaEmail,CuentaEstado,CuentaTipo,CuentaGenero,CuentaFoto) 
        VALUES(:Codigo,:Privilegio,:Usuario,:Clave,:Email,:Estado,:Tipo,:Genero,:Foto)");
        $sql->bindParam(":Codigo", $datos['Codigo']);
        $sql->bindParam(":Privilegio", $datos['Privilegio']);
        $sql->bindParam(":Usuario", $datos['Usuario']);
        $sql->bindParam(":Clave", $datos['Clave']);
        $sql->bindParam(":Email", $datos['Email']);
        $sql->bindParam(":Estado", $datos['Estado']);
        $sql->bindParam(":Tipo", $datos['Tipo']);
        $sql->bindParam(":Genero", $datos['Genero']);
        $sql->bindParam(":Foto", $datos['Foto']);
        $sql->execute();
        return $sql;
    }

    // function eliminar cuenta
    protected function eliminar_cuenta($codigo){
        $sql = self::conectar()->prepare("DELETE FROM cuenta WHERE CuentaCodigo=:Codigo");
        $sql->bindParam(":Codigo", $codigo);
        $sql->execute();
        return $sql;
    }

    //Funcion agregar bitacora
    protected function guardar_bitacora($datos){
        $sql = self::conectar()->prepare("INSERT INTO bitacora(BitacoraCodigo,BitacoraFecha,BitacoraHoraInicio,BitacoraHoraFinal,BitacoraTipo,BitacoraAnio,CuentaCodigo) 
        VALUES(:Codigo,:Fecha,:HoraInicio,:HoraFinal,:Tipo,:Anio,:Cuenta)");
        $sql->bindParam(":Codigo", $datos['Codigo']);
        $sql->bindParam(":Fecha", $datos['Fecha']);
        $sql->bindParam(":HoraInicio", $datos['HoraInicio']);
        $sql->bindParam(":HoraFinal", $datos['HoraFinal']);
        $sql->bindParam(":Tipo", $datos['Tipo']);
        $sql->bindParam(":Anio", $datos['Anio']);
        $sql->bindParam(":Cuenta", $datos['Cuenta']);
        $sql->execute();
        return $sql;
     
    }

    // Funcion actualizar bitacora
    protected function actualizar_bitacora($codigo, $hora){
        $sql = self::conectar()->prepare("UPDATE bitacora SET BitacoraHoraFinal=:Hora WHERE BitacoraCodigo=:Codigo");
        $sql->bindParam(":Hora", $hora);
        $sql->bindParam(":Codigo", $codigo);
        $sql->execute();
        return $sql;
    }

    // Funcion eliminar bitacora
    protected function eliminar_bitacora($codigo){
        $sql = self::conectar()->prepare("DELETE FROM bitacora WHERE CuentaCodigo=:Codigo");
        $sql->bindParam(":Codigo", $codigo);
        $sql->execute();
        return $sql;
    }


    //funcion para encriptar contraseñas.
    public static function encryption($string){
        $output=FALSE;
        $key=hash('sha256', SECRET_KEY);
        $iv=substr(hash('sha256', SECRET_IV), 0, 16);
        $output=openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output=base64_encode($output);
        return $output;
    }
    public static function decryption($string){
        $key=hash('sha256', SECRET_KEY);
        $iv=substr(hash('sha256', SECRET_IV), 0, 16);
        $output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }

    //función para generar códigos aleatorios
    protected function generar_codigo_aleatorio($letra,$longitud,$num){
        for($i=1; $i<=$longitud; $i++){
            $numero=rand(0,9);
            $letra.=$numero;
        }
        return $letra.$num;
    }

    // Funcion para limpiar cadenas de texto (evitar inyección sql).
    protected function limpiar_cadena($cadena){
        $cadena = trim($cadena);
        $cadena = stripslashes($cadena); //si tiene '\' se quita.
        $cadena = str_ireplace("<script>", "", $cadena);
        $cadena = str_ireplace("</script>", "", $cadena);
        $cadena = str_ireplace("<script src>", "", $cadena);
        $cadena = str_ireplace("<script type=>", "", $cadena);
        $cadena = str_ireplace("SELECT * FROM", "", $cadena);
        $cadena = str_ireplace("DELETE FROM", "", $cadena);
        $cadena = str_ireplace("INSERT INTO", "", $cadena);
        $cadena = str_ireplace("--", "", $cadena);
        $cadena = str_ireplace("^", "", $cadena);
        $cadena = str_ireplace("[", "", $cadena);
        $cadena = str_ireplace("]", "", $cadena);
        $cadena = str_ireplace("=", "", $cadena);
        return $cadena;
    }

    // Funcion para mostrar alertas
    protected function sweet_alert($datos){
        if($datos['Alerta']=="simple"){
            $alerta = "
            <script>
            
                swal(
                    '".$datos['Titulo']."',
                    '".$datos['Texto']."',
                    '".$datos['Tipo']."'
                );
              
            </script>
            ";
        }elseif($datos['Alerta']=="recargar"){
            $alerta = "
            <script>
            
                swal({
                    title: '".$datos['Titulo']."',
                    text: '".$datos['Texto']."',
                    type: '".$datos['Tipo']."',
                    confirmButtonText: 'Aceptar'
                }).then(function() {
                    location.reload();
                });
              
            </script>
            ";
        }elseif($datos['Alerta']=="limpiar"){
            $alerta = "
            <script>
            
                swal({
                    title: '".$datos['Titulo']."',
                    text: '".$datos['Texto']."',
                    type: '".$datos['Tipo']."',
                    confirmButtonText: 'Aceptar'
                }).then(function() {
                    $('.FormularioAjax')[0].reset();
                });
              
            </script>
            ";
        }

        return $alerta; 
    }

}