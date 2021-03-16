<?php
require_once 'conexion/conexion.php';
require_once 'clases/respuestas.class.php';

class TercerModulo extends Conexion{
    private $id = "";
    private $idsegundoModulo = "";
    private $descripcio = "";
    private $cantidadInicio = "";
    private $cantidadFinal = "";
    private $fechainicio = "0000-00-00 00:00:00";
    private $fechaFin = "0000-00-00 00:00:00";
    private $estado = "";

    public function mostrar($id){
        $query = "select pm.id as idPrimerModulo, pm.idCliente, pm.idPedido, pm.idPieza, pm.idMaquina, pm.cantidad, pm.colorPrimario, pm.colorSecundario, pm.colorTerciario, pm.descripcion, pm.estado,
        m.nombre, p.nombre as nombrePieza, p.idModelo, p.talla, p.foto, mo.nombre as nombreModelo, c.nombre as nombreCliente
        from primerModulo pm join maquina m on pm.idMaquina=m.id join pieza p on p.id=pm.idPieza join modelo mo on mo.id=p.idModelo join clientes c on c.id=pm.idCliente
        where pm.estado='1' and pm.idMaquina='".$id."'";

        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    public function insert($json){
        $respuestas = new Respuestas();
        $datos = json_decode($json, true);

        if(!isset($datos['id']) ||
            !isset($datos['idsegundoModulo']) ||
            !isset($datos['descripcio']) ||
            !isset($datos['cantidadInicio']) ||
            !isset($datos['cantidadFinal']) ||
            !isset($datos['fechainicio']) ||
            !isset($datos['fechaFin']) ||
            !isset($datos['estado'])){
                return $respuestas->error_400();
        }else {
            $this->id = $datos['id'];
            $this->idsegundoModulo = $datos['idsegundoModulo'];
            $this->descripcio = $datos['descripcio'];
            $this->cantidadInicio = $datos['cantidadInicio'];
            $this->cantidadFinal = $datos['cantidadFinal'];
            $this->fechainicio = $datos['fechainicio'];
            $this->fechaFin = $datos['fechaFin'];
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
        $query = "INSERT INTO tercerModulo(id, idsegundoModulo, descripcio, cantidadInicio, cantidadFinal, fechainicio, fechaFin, estado)VALUES
        (NULL, '".$this->id."', '".$this->idsegundoModulo."', '".$this->descripcio."', '".$this->cantidadInicio."', '".$this->cantidadFinal."', '".$this->fechainicio."', '".$this->fechaFin."', '".$this->estado."')";
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
            !isset($datos['idsegundoModulo']) ||
            !isset($datos['descripcio']) ||
            !isset($datos['cantidadInicio']) ||
            !isset($datos['cantidadFinal']) ||
            !isset($datos['fechainicio']) ||
            !isset($datos['fechaFin']) ||
            !isset($datos['estado'])){
                return $respuestas->error_400();
        }else {
            $this->id = $datos['id'];
            $this->idsegundoModulo = $datos['idsegundoModulo'];
            $this->descripcio = $datos['descripcio'];
            $this->cantidadInicio = $datos['cantidadInicio'];
            $this->cantidadFinal = $datos['cantidadFinal'];
            $this->fechainicio = $datos['fechainicio'];
            $this->fechaFin = $datos['fechaFin'];
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
        $query = "UPDATE tercerModulo SET idsegundoModulo= '".$this->idsegundoModulo."', descripcio= '".$this->descripcio."', cantidadInicio= ".$this->cantidadInicio.", cantidadFinal=".$this->cantidadFinal.", fechainicio='".$this->fechainicio."', fechaFin='".$this->fechaFin."', estado=".$this->estado."";
        $res = parent::nonQueryId($query);

        if($res == "ok"){
           return "ok";
        }else{
            return "error";
        }
    }
}