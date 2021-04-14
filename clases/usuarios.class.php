<?php
require_once 'conexion/conexion.php';
require_once 'clases/respuestas.class.php';

class Usuarios extends Conexion{
    public function mostrarUsuarios($idUsuario){
        $respuestas = new Respuestas();
        $query = 'SELECT * FROM usuarios WHERE id='.$idUsuario;
        $datos = parent::obtenerDatos($query);

        if($datos == null || $datos == ""){
            return $respuestas->error_400("Datos no encontrados");
        }else{
            return $datos;
        }

    }
}