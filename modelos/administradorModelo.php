<?php
if($pretionAjax){
    require_once "../nucleo/mainModel.php";
}else{
    require_once "./nucleo/mainModel.php";
}

class administradorModelo extends mainModel{
    
    // Modelo agregar administrador
    protected function agregar_administrador_modelo($datos){
        $sql=mainModel::conectar()->prepare("INSERT INTO administrador(AdminDNI, AdminNombre, AdminApellido, AdminTelefono, AdminDireccion, CuentaCodigo) 
        VALUES(:DNI,:Nombre,:Apellido,:Telefono,:Direccion,:Codigo)");
        $sql->bindParam(":DNI", $datos['DNI']);
        $sql->bindParam(":Nombre", $datos['Nombre']);
        $sql->bindParam(":Apellido", $datos['Apellido']);
        $sql->bindParam(":Telefono", $datos['Telefono']);
        $sql->bindParam(":Direccion", $datos['Direccion']);
        $sql->bindParam(":Codigo", $datos['Codigo']);
        $sql->execute();
        return $sql;
    }

}
