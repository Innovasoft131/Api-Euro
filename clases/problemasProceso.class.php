<?php
require_once 'conexion/conexion.php';
require_once 'clases/respuestas.class.php';

class ProblemasProceso extends Conexion{
    private $id = "";
    private $idPedido = "";
    private $idprimerModulo = "";
    private $idSegundoModulo = "";
    private $idtercerModulo = "";

    public function insert($json){
        $respuestas = new Respuestas();
        $datos = json_decode($json, true);

        if(!isset($datos['id']) ||
            !isset($datos['idPedido']) ||
            !isset($datos['idprimerModulo']) ||
            !isset($datos['idSegundoModulo']) ||
            !isset($datos['idtercerModulo'])){
                return $respuestas->error_400();
        }else {
            $this->id = $datos['id'];
            $this->idPedido = $datos['idPedido'];
            $this->idprimerModulo = $datos['idprimerModulo'];
            $this->idSegundoModulo = $datos['idSegundoModulo'];
            $this->idtercerModulo = $datos['idtercerModulo'];

            $res = $this->insertar();

            if($res == "ok"){
                $respuesta = $respuestas -> response;
                    $respuesta['result'] = array(
                        "resultado" => "Guardado"
                    );
                    return $respuesta;
            }else {
                return $respuestas->error_500();
            }
        }
    }

    private function insertar(){
        $query "INSERT INTO problemasProceso(id, idPedido, idprimerModulo, idSegundoModulo, idtercerModulo) VALUES
        (null, ".$this->id.", ".$this->idPedido.", ".$this->idprimerModulo.", ".$this->idSegundoModulo.", ".$this->idtercerModulo.")";

        $res = parent::nonQueryId($query);

        if($res == "ok"){
        return "ok";
        }else{
            return "error";
        }
    }
}