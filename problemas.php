<?php

require_once 'clases/respuestas.class.php';
require_once 'clases/problemas.class.php';

$respuestas = new Respuestas();
$problemas = new Problemas();

if($_SERVER['REQUEST_METHOD']){
    if(!isset($_GET['id']) || !isset($_GET['tabla'])){
        $res = $respuestas->error_200("Argumento no valido");
    }

    if(isset($_GET['tabla'])){
        $tabla = $_GET['tabla'];
        if($tabla == "problemas"){
            $res = $problemas->obtenerProblemas();
        }
    }

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $res = $problemas->obtenerProblema($id);
    }
    header('Content-Type: application/json');
    echo json_encode($res);
    http_response_code(200);
}