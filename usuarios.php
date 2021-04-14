<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/usuarios.class.php';

$respuestas = new Respuestas();
$usuarios = new Usuarios();

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['idUsuario'])){
        $idUsuario = $_GET['idUsuario'];

        $datos = $usuarios->mostrarUsuarios($idUsuario);

        header('Content-Type: application/json');
        http_response_code(200);


      
        echo json_encode($datos);

    }

}else{
    header('Content-Type: application/json');
    $datosArr = $respuestas->error_405();
    
    echo json_encode($datosArr);
}