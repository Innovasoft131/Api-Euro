<?php
require_once 'conexion/conexion.php';
require_once 'clases/respuestas.class.php';

class SegundoModulo extends Conexion{
    private $id = "";
    private $idPrimerModulo = "";
    private $descripcio = "";
    private $cantidadInicio = "";
    private $cantidadFinal = "";
    private $fechainicio = "0000-00-00 00:00:00";
    private $fechaFin = "0000-00-00 00:00:00";
    private $fusion = "";
    private $estado = "";

    public function mostrar($id){
        $query = "select pm.id as idPrimerModulo, pm.idCliente, pm.idPedido, pm.idPieza, pm.idMaquina, pm.cantidad, pm.colorPrimario, pm.colorSecundario, pm.colorTerciario, pm.descripcion, pm.estado,
        m.nombre, p.nombre as nombrePieza, p.idModelo, p.talla, p.foto, mo.nombre as nombreModelo, c.nombre as nombreCliente, sm.cantidadFinal
        from primerModulo pm join maquina m on pm.idMaquina=m.id join pieza p on p.id=pm.idPieza join modelo mo on mo.id=p.idModelo join clientes c on c.id=pm.idCliente
        join segundoModulo sm on sm.idPrimerModulo=pm.id where (sm.estado='1' and pm.estado='1') and pm.idMaquina='".$id."'";

        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    public function insert($json){
        $respuestas = new Respuestas();
        $datos = json_decode($json, true);

        if(!isset($datos['id']) ||
            !isset($datos['idPrimerModulo']) ||
            !isset($datos['descripcio']) ||
            !isset($datos['cantidadInicio']) ||
            !isset($datos['cantidadFinal']) ||
            !isset($datos['fechainicio']) ||
            !isset($datos['fechaFin']) ||
            !isset($datos['fusion']) ||
            !isset($datos['estado'])){
                return $respuestas->error_400();
        }else {
            $this->id = $datos['id'];
            $this->idPrimerModulo = $datos['idPrimerModulo'];
            $this->descripcio = $datos['descripcio'];
            $this->cantidadInicio = $datos['cantidadInicio'];
            $this->cantidadFinal = $datos['cantidadFinal'];
            $this->fechainicio = $datos['fechainicio'];
            $this->fechaFin = $datos['fechaFin'];
            $this->fusion = $datos['fusion'];
            $this->estado = $datos['estado'];

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
        $query = "INSERT INTO segundoModulo(id, idPrimerModulo, descripcio, cantidadInicio, cantidadFinal, fechainicio, fechaFin, fusion, estado) VALUES".
        "('".$this->id."', '".$this->idPrimerModulo."', '".$this->descripcio."', '".$this->cantidadInicio."', '".$this->fechainicio."', '".$this->fechaFin."', '".$this->fusion."', '".$this->estado."')";
        $res = parent::nonQueryId($query);

        if($res == "ok"){
           return "ok";
        }else{
            return "error";
        }
    }


    public function edit($json){
        $respuestas = new Respuestas();
        $datos = json_decode($json, true);

        if(!isset($datos['id']) ||
            !isset($datos['idPrimerModulo']) ||
            !isset($datos['descripcio']) ||
            !isset($datos['cantidadInicio']) ||
            !isset($datos['cantidadFinal']) ||
            !isset($datos['fechainicio']) ||
            !isset($datos['fechaFin']) ||
            !isset($datos['fusion']) ||
            !isset($datos['estado'])){
                return $respuestas->error_400();
        }else {
            $this->id = $datos['id'];
            $this->idPrimerModulo = $datos['idPrimerModulo'];
            $this->descripcio = $datos['descripcio'];
            $this->cantidadInicio = $datos['cantidadInicio'];
            $this->cantidadFinal = $datos['cantidadFinal'];
            $this->fechainicio = $datos['fechainicio'];
            $this->fechaFin = $datos['fechaFin'];
            $this->fusion = $datos['fusion'];
            $this->estado = $datos['estado'];

            $res = $this->modificar();

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

    private function modificar(){
        $query = "UPDATE segundoModulo SET idPrimerModulo= '".$this->idPrimerModulo."', descripcio='".$this->descripcio."', cantidadInicio= '".$this->cantidadInicio."', cantidadFinal='".$this->cantidadFinal."', fechainicio= '".$this->fechainicio."', fechaFin= '".$this->fechaFin."', fusion='".$this->fusion."', estado='".$this->estado."' WHERE id='".$this->id."'";
        $res = parent::nonQueryId($query);

        if($res == "ok"){
           return "ok";
        }else{
            return "error";
        }
    }
}