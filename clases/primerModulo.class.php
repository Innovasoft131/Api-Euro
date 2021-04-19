<?php
require_once 'conexion/conexion.php';
require_once 'clases/respuestas.class.php';
class PrimerModulo extends Conexion{

    private $tabla = "primerModulo";
    private $idPrimerModulo = "";
    private $idcliente = "";
    private $idPedido = "";
    private $idPieza = "";
    private $idMaquina = "";
    private $fechainicio = "0000-00-00 00:00:00";
    private $fechaFin = "0000-00-00 00:00:00";
    private $cantidad = "";
    private $colorPrimario = "";
    private $colorSecundario = "";
    private $colorTerciario = "";
    private $descripcion = "";
    private $estado = "";
    public function listaPrimerModulo($id){
        /*
        $inicio = 0;
        $cantidad = 100;

        if($pagina > 1){
            $inicio = ($cantidad * ($pagina - 1 )) + 1;
            $cantidad = $cantidad * $pagina; 
        }
        */
        $query = "SELECT * FROM ".$this->tabla." WHERE id= $id";
        $datos = parent::obtenerDatos($query);
        
        return $datos;
    }

    public function post($json){
        $respuestas = new Respuestas();
        $datos = json_decode($json, true);
        

        if(!isset($datos['idcliente']) || 
            !isset($datos['idPedido']) ||
            !isset($datos['idPieza']) ||
            !isset($datos['idMaquina']) ||
            !isset($datos['fechainicio']) ||
            !isset($datos['fechaFin']) ||
            !isset($datos['cantidad']) ||
            !isset($datos['colorPrimario']) ||
            !isset($datos['colorSecundario']) ||
            !isset($datos['colorTerciario']) ||
            !isset($datos['descripcion']) ||
            !isset($datos['estado']) ){
                return $respuestas->error_400();
            }else{
                $this->idcliente = $datos['idcliente'];
                $this->idPedido = $datos['idPedido'];
                $this->idPieza = $datos['idPieza'];
                $this->idMaquina = $datos['idMaquina'];
                $this->fechainicio = $datos['fechainicio'];
                $this->fechaFin = $datos['fechaFin'];
                $this->cantidad = $datos['cantidad'];
                $this->colorPrimario = $datos['colorPrimario'];
                $this->colorSecundario = $datos['colorSecundario'];
                $this->colorTerciario = $datos['colorTerciario'];
                $this->descripcion = $datos['descripcion'];
                $this->estado = $datos['estado'];

                $res = $this->insetarPrimerModulo();
                
                if($res == "ok"){
                    $respuesta = $respuestas -> response;
                    $respuesta['result'] = array(
                        "resultado" => "Guardado"
                    );
                    return $respuesta;
                }else{
                    return $respuestas->error_500();
                }
            }

    }

    public function edit($json){
        $respuestas = new Respuestas();
        $datos = json_decode($json, true);
        if(!isset($datos['estado']) || !isset($datos['idPrimerModulo'])){
            return $respuestas->error_400();
        }else{
            $this->estado = $datos['estado'];
            $this->idPrimerModulo = $datos['idPrimerModulo'];
            $res = $this->editarEstado();

            if($res == "ok"){
                $respuesta = $respuestas -> response;
                $respuesta['result'] = array(
                    "resultado" => "Guardado"
                );
                return $respuesta;
            }else{
                return $respuestas->error_500();
            }
        }

    }

    private function editarEstado(){
        $query = 'update primerModulo set estado= '.$this->estado.' where id='.$this->idPrimerModulo;
        $res = parent::nonQueryId($query);

        if($res == "ok"){
           return "ok";
        }else{
            return "error";
        }
    }

    private function insetarPrimerModulo(){
        $query = "INSERT INTO ".$this->tabla." (idCliente, idPedido, idPieza, idMaquina, fechainicio, fechaFin, cantidad, colorPrimario, colorSecundario, colorTerciario, descripcion, estado) VALUES
         ('".$this->idcliente ."', '".$this->idPedido."', '".$this->idPieza."', '".$this->idMaquina."', '".$this->fechainicio."', '".$this->fechaFin."', '".$this->cantidad."', '".$this->colorPrimario."', '".$this->colorSecundario."', '".$this->colorTerciario."', '".$this->descripcion."', '".$this->estado."')";

         $res = parent::nonQueryId($query);

         if($res == "ok"){
            return "ok";
         }else{
             return "error";
         }
    }

}