<?php

require_once 'conexion/conexion.php';
require_once 'clases/respuestas.class.php';

class Problemas extends Conexion{

    public function obtenerProblemas(){
        $query = "SELECT * FROM problemas";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    public function obtenerProblema($id){
        $query = "SELECT * FROM problemas WHERE id=$id";
        $datos = parent::obtenerDatos($query);
        return $datos;
    }
}