<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/primerModulo.class.php';

$respuestas = new Respuestas();
$primerModulo = new PrimerModulo();

if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET["id"])){
        $idprimerModulo = $_GET["id"];
        $datosPrimerModulo = $primerModulo->listaPrimerModulo($idprimerModulo);
        header('Content-Type: application/json');
        echo json_encode($datosPrimerModulo);
        http_response_code(200);
    }
    

}elseif($_SERVER['REQUEST_METHOD'] == "POST") {
    // recibimos datos
    $postBody = file_get_contents("php://input");

    //enviamos los datos a procesar
    $res = $primerModulo->post($postBody);
    
    // devolvemos una respuesta
    header('Content-Type: application/json');
    if(isset($res["result"]["error_id"])){   
        $responsoCode = $res["result"]["error_id"];
        http_response_code($responsoCode);

    }else{
        http_response_code(200);
    }

    echo json_encode($res);


} elseif($_SERVER['REQUEST_METHOD'] == "PUT") {
    echo "funcion editar esta en desarrollo";
}elseif($_SERVER['REQUEST_METHOD'] == "DELETE") {
    echo "funcion eliminar esta en desarrollo";
}else{
    header('Content-Type: application/json');
    $datosArr = $respuestas->error_405();
    
    echo json_encode($datosArr);
}

