<?php

require_once 'clases/respuestas.class.php';
require_once 'clases/clientes.class.php';

$respuestas = new Respuestas();
$clientes = new Clientes();

if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(!isset($_GET['id']) || !isset($_GET['tabla'])){
        $res = $respuestas->error_200("Argumento no valido");
    }

    if(isset($_GET['tabla'])){
        $tabla = $_GET['tabla'];

        if($tabla == "clientes"){
            $res = $clientes->obtenerClientes();
        }
    }

    if(isset($_GET['id'])){
        $idCliente = $_GET['id'];
        $res = $clientes->obtenerCliente($idCliente);
    }

    header('Content-Type: application/json');
    echo json_encode($res);
    http_response_code(200);
}