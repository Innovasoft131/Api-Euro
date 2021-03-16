<?php

require_once 'conexion/conexion.php';
require_once 'clases/respuestas.class.php';

class Clientes extends Conexion{

    public function obtenerClientes(){
        $query = "SELECT * FROM clientes";
        $datos = parent::obtenerDatos($query);

        return $datos;

    }

    public function obtenerCliente($id){
        $query = "SELECT * FROM clientes WHERE id = $id";
        $datos = parent::obtenerDatos($query);

        return $datos;
    }
}