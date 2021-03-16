<?php

require_once "clases/conexion/conexion.php";

$conexion = new conexion();

$query = "INSERT INTO usuarios(nombre, usuario, password, perfil, foto, estado, ultimo_login, fecha) VALUES ('alvarez', 'alvarez', '123', 'Especial', '',1, '0000-00-00 00:00:00', now())";

print_r($conexion->nonQueryId($query));

?>

hola index
