<?php

require_once 'clases/respuestas.class.php';
require_once 'clases/piezas.class.php';

$respuestas = new Respuestas();
$piezas = new Piezas();

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(!isset($_GET['id']) || !isset($_GET['tabla'])){
        $res = $respuestas->error_200("Argumento no valido");
    }

    if(isset($_GET['tabla'])){
        $tabla = $_GET['tabla'];
        
        if($tabla == "piezas"){
            $res = $piezas->obtenerPiezas();
        }
      
    }

    if(isset($_GET['id'])){
        $idPieza = $_GET['id'];
        $res = $piezas->obtenerPieza($idPieza);
    }

  
    header('Content-Type: application/json');
    echo json_encode($res);
    http_response_code(200);
}