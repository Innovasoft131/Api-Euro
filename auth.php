<?php
require_once 'clases/auth.class.php';
require_once 'clases/respuestas.class.php';

 $auth = new Auth();
 $respuestas = new Respuestas();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // recibiendo datos 
    $postBody = file_get_contents("php://input");

    // enviamos datos a procesar
 
    $datosArray = $auth->login($postBody);

    // devolvemos datos solicitados
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){   
        $responsoCode = $datosArray["result"]["error_id"];
        http_response_code($responsoCode);

    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);

}else{
    header('Content-Type: application/json');
    $datosArr = $respuestas->error_405();
    
    echo json_encode($datosArr);
}