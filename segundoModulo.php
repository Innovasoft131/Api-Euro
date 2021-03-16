<?php

require_once 'clases/respuestas.class.php';
require_once 'clases/segundoModulo.class.php';

$respuestas = new Respuestas();
$segundoModulo = new SegundoModulo();

if($_SERVER['REQUEST_METHOD'] == 'GET'){

    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $datos = $segundoModulo->mostrar($id);
        header('Content-Type: application/json');
        http_response_code(200);
      
        echo json_encode($datos);
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