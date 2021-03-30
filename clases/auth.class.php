<?php
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';
class Auth extends Conexion{
 
    public function login($json){
        $respuestas = new Respuestas();
        $datos = json_decode($json,true);

        if(!isset($datos['usuario']) || !isset($datos['password'])){
            // error
            return $respuestas->error_400();
        }else{
            $usuario = $datos['usuario'];
            $password = $datos['password'];
            $password = parent::encriptar($password);
            $dato = $this->obtenerDatosUsuarios($usuario);

            if($dato){
                // verificar password 
                if($password == $dato[0]['password']){
                    if($dato[0]['estado'] == "1"){
                        // crear token
                    //    $verifivar = $this->insertarToken($dato[0]['id']);
                    $verifivar = true;
                        if($verifivar){
                            $res =  $respuestas->response;
                            $res['result'] = array(
                                "idUsuario" => $dato[0]['id'],
                                "usuario" => $dato[0]['usuario'],
                                "foto" => $dato[0]['foto'],
                                "perfil" => $dato[0]['perfil'],
                                "estado" => $dato[0]['estado']
                            );
                            return $res;
                        }else{
                            return $respuestas->error_500("Error Interno, No se guardo");
                        }
                    }else{
                        // el usuario esta inactivo
                        return $respuestas->error_200("El usuario $usuario esta inactivo");
                    }
                }else{
                    // la contraseña es incorrecta
                    return $respuestas->error_200("El contraseña  es incorrecta");
                }
                
            }else{
                // si no existe
                return $respuestas->error_200("El usuario $usuario no existe");
            }
        }
    }

    private function obtenerDatosUsuarios($usuario){
        $consulta = "SELECT * FROM usuarios WHERE usuario= '$usuario'";
        $datos = parent::obtenerDatos($consulta);

        if(isset($datos[0]['usuario'])){
            return $datos;

        }else{
            return 0;
        }
    }

    private function insertarToken($usuario){
        $val = true;
        $token = bin2hex(openssl_random_pseudo_bytes(16,$val));
        $date = date("y-m-d h:i");
        $estado = "1";
        
        $insert = "INSERT INTO usuariosToken(id,idUsuario,token,estado,fecha)VALUES(null,'$usuario','$token','$estado','$date')  ";
        $res = parent::nonQueryId($insert);
       
        if($res == "ok"){
            return $token;
        }else{
            return false;
        }
    }

    
}
