<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/problemasProceso.class.php';

$respuestas = new Respuestas();
$problemasProceso = new ProblemasProceso();

if($_SERVER['REQUEST_METHOD'] == 'GET'){

}elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // recibimos datos
    $postBody = file_get_contents("php://input");
 
    //enviamos los datos a procesar
    $res = $problemasProceso->insert($postBody);
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