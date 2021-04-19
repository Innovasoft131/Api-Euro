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
        
            if($res > 1){
                $respuesta = $respuestas -> response;
                    $respuesta['result'] = array(
                        "idProblemaProceso" => $res,
                        "resultado" => "Guardado"
                    );
                    return $respuesta;
            }else {
                return $respuestas->error_500();
            }
        }
    }

    private function insertar(){
        if($this->idprimerModulo == "" && $this->idSegundoModulo == "" && $this->idtercerModulo == ""){
            $query = 'INSERT INTO problemasProceso(id, idPedido, idprimerModulo, idSegundoModulo, idtercerModulo) VALUES
            (null, '.$this->idPedido.', null, null, null)';
        }elseif($this->idprimerModulo != "" && $this->idSegundoModulo == "" && $this->idtercerModulo == ""){
            $query = 'INSERT INTO problemasProceso(id, idPedido, idprimerModulo, idSegundoModulo, idtercerModulo) VALUES
            (null, '.$this->idPedido.', '.$this->idprimerModulo.', null, null)';
            
        }elseif($this->idSegundoModulo != "" && $this->idprimerModulo == "" && $this->idtercerModulo == ""){
            $query = 'INSERT INTO problemasProceso(id, idPedido, idprimerModulo, idSegundoModulo, idtercerModulo) VALUES
            (null, '.$this->idPedido.', null, '.$this->idSegundoModulo.', null)';
            
        }elseif($this->idtercerModulo != "" && $this->idprimerModulo == "" && $this->idSegundoModulo == ""){
            $query = 'INSERT INTO problemasProceso(id, idPedido, idprimerModulo, idSegundoModulo, idtercerModulo) VALUES
            (null, '.$this->idPedido.', null, null, '.$this->idtercerModulo.')';
        }else{
            $query = 'INSERT INTO problemasProceso(id, idPedido, idprimerModulo, idSegundoModulo, idtercerModulo) VALUES
            (null, '.$this->idPedido.', '.$this->idprimerModulo.', '.$this->idSegundoModulo.', '.$this->idtercerModulo.')';
        }
        
        
        
        
        $res = parent::nonQueryIds($query);

        return $res;
    }
}