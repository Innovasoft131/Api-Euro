<?php

require_once 'clases/respuestas.class.php';
require_once 'clases/segundoModulo.class.php';
 
$respuestas = new Respuestas();
$segundoModulo = new SegundoModulo();

if($_SERVER['REQUEST_METHOD'] == 'GET'){

    if(isset($_GET['id'])){
        $id = $_GET['id'];
      //  $datos = $segundoModulo->mostrar($id);

        $datosPm = $segundoModulo->mostrarPrimerModulo($id);
        
        $desglosePm = $segundoModulo -> primerModuloDesglose($datosPm["idPrimerModulo"], $id);
        //$id,$datosPm["idPrimerModulo"]
        $maquina = $segundoModulo -> maquina($id,$datosPm["idPrimerModulo"]);

        $modelo = $segundoModulo -> modelo($id,$datosPm["idPrimerModulo"]);

        $color = $segundoModulo -> color($id);

        $respuesta = array(
            "primerModulo" => $datosPm,
            "PrimerModuloDesglose" => $desglosePm,
            "Maquina" => $maquina,
            "Modelo" => $modelo,
            "color" => $color
        );

        header('Content-Type: application/json');
        http_response_code(200);


      
        echo json_encode($respuesta);
    }elseif(isset($_GET["estado"])){
        // obtener datos del segundo modulo con estado
        $estado = $_GET["estado"];

        $datos = $segundoModulo -> mostrarSegundoModulo($estado);
        header('Content-Type: application/json');
        http_response_code(200);
      
        echo json_encode($datos);

    }elseif(isset($_GET["idPieza"])){
        // obtener colores de la pieza
        $idPieza = $_GET["idPieza"];

        $respuesta = $segundoModulo ->obtenerColor($idPieza);
        header('Content-Type: application/json');
        http_response_code(200);
      
        echo json_encode($respuesta);

    }elseif(isset($_GET["idPrimerModulo"])){
        // obtener maquinas asignadas
        $idPrimerModulo = $_GET["idPrimerModulo"];

        $respuesta = $segundoModulo ->obtenerMaquina($idPrimerModulo);

        header('Content-Type: application/json');
        http_response_code(200);
      
        echo json_encode($respuesta);

    }else {
        header('Content-Type: application/json');
        $datosArr = $respuestas->error_405();   
        echo json_encode($datosArr);
    }

}elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // recibimos datos
    $postBody = file_get_contents("php://input");

    //enviamos los datos a procesar
    $res = $segundoModulo->insert($postBody);
    // devolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($res["result"]["error_id"])){   
        $responsoCode = $res["result"]["error_id"];
        http_response_code($responsoCode);

    }else{
        http_response_code(200);
    }

    echo json_encode($res);
}elseif ($_SERVER['REQUEST_METHOD'] == 'PUT'){
    // recibimos datos
    $postBody = file_get_contents("php://input");

    $res = $segundoModulo->edit($postBody);

    // devolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($res["result"]["error_id"])){   
        $responsoCode = $res["result"]["error_id"];
        http_response_code($responsoCode);

    }else{
        http_response_code(200);
    }

    echo json_encode($res);

}else{
    header('Content-Type: application/json');
    $datosArr = $respuestas->error_405();
    
    echo json_encode($datosArr);
}