<?php

require_once 'conexion/conexion.php';
require_once 'clases/respuestas.class.php';

class Piezas extends Conexion{

    public function obtenerPiezas(){

        $query = "SELECT * FROM pieza";
        $datos = parent::obtenerDatos($query);

        return $datos;

    }

    public function obtenerPieza($idPieza){

        $query = "SELECT * FROM pieza WHERE id=$idPieza";
        $datos = parent::obtenerDatos($query);

        return $datos;

    }
}