<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/problemasDesglose.class.php';

$respuestas = new Respuestas();
$problemasDesglose = new problemasDesglose();

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET["accion"])){
        $tabla = $_GET["accion"];
        $datos = $problemasDesglose->problemas($tabla);
        header('Content-Type: application/json');
        http_response_code(200);


      
        echo json_encode($datos);

    }

}elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // recibimos datos
    $postBody = file_get_contents("php://input");

    //enviamos los datos a procesar
    $res = $problemasDesglose->insert($postBody);
    // devolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($res["result"]["error_id"])){   
        $responsoCode = $res["result"]["error_id"];
        http_response_code($responsoCode);   
    }else{
        http_response_code(200);
   }
    
    echo json_encode($res);
}