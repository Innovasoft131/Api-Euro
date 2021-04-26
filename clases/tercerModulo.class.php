<?php
require_once 'conexion/conexion.php';
require_once 'clases/respuestas.class.php';

class TercerModulo extends Conexion{
    private $id = "";
    private $idPrimerModulo = "";
    private $idPieza = "";
    private $idColor = "";
    private $idsegundoModulo = "";
    private $idTalla = "";
    private $idPrimerModuloD = "";
    private $idPedido = "";
    private $idMaquinaProceso = "";
    private $idUsuario = "";
    private $descripcio = "";
    private $cantidadInicio = "";
    private $cantidadFinal = "";
    private $cantidadefectuosas = "";
    private $fechainicio = "0000-00-00 00:00:00";
    private $fechaFin = "0000-00-00 00:00:00";
    private $estado = "";

    public function mostrar($id){
        $query = 'select pmd.*, mp.cantidad as cantidad_pieza, c.nombre as color, pt.talla, ph.fecha as fecha_pedido, pm.idPedido, p.nombre as nombre_pieza, m.nombre as nombre_modelo  from primerModulo pm join primermodulodesglose pmd on pmd.idPrimerModulo=pm.id join maquinasproceso mp on mp.idPrimerModuloD=pmd.id
        join colorPieza cp on pmd.idColor = cp.id join color c on c.id = cp.idColor join piezaTalla pt on  pmd.idTalla = pt.id join pedidosHechos ph on ph.id = pm.idPedido
        join pieza p on p.id = pmd.idPieza join modelo m on m.id = p.idModelo join segundoModulo sm on sm.idPrimerModulo=pmd.idPrimerModulo
        where mp.idMaquina ="'.$id.'" and ( pm.estado = 1 and mp.estado = 1 and sm.estado=1)';

        $datos = parent::obtenerDatos($query);
        return $datos;
    }

    public function insert($json){
        $respuestas = new Respuestas();
        $datos = json_decode($json, true);

        if(!isset($datos['id']) ||
            !isset($datos['idsegundoModulo']) ||
            !isset($datos['idPedido']) ||
            !isset($datos['idMaquinaProceso']) ||
            !isset($datos['idUsuario']) ||
            !isset($datos['idPieza']) ||
            !isset($datos['idColor']) ||
            !isset($datos['idTalla']) ||
            !isset($datos['idPrimerModuloD']) ||
            !isset($datos['descripcio']) ||
            !isset($datos['cantidadInicio']) ||
            !isset($datos['cantidadFinal']) ||
            !isset($datos['cantidadefectuosas']) ||
            !isset($datos['fechainicio']) ||
            !isset($datos['fechaFin']) ||
            !isset($datos['estado'])){
                return $respuestas->error_400();
        }else {
            $this->id = $datos['id'];
            $this->idsegundoModulo = $datos['idsegundoModulo'];
            $this->idPedido = $datos['idPedido'];
            $this->idMaquinaProceso = $datos['idMaquinaProceso'];
            $this->idUsuario = $datos['idUsuario'];
            $this->idPieza = $datos['idPieza'];
            $this->idColor = $datos['idColor'];
            $this->idTalla = $datos['idTalla'];
            $this->idPrimerModuloD = $datos['idPrimerModuloD'];
            $this->descripcio = $datos['descripcio'];
            $this->cantidadInicio = $datos['cantidadInicio'];
            $this->cantidadFinal = $datos['cantidadFinal'];
            $this->cantidadefectuosas = $datos['cantidadefectuosas'];
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
        $query = 'INSERT INTO tercerModulo(id, idsegundoModulo, idPedido, idMaquinaProceso, idUsuario, idPieza, idColor, idTalla, idPrimerModuloD, descripcio, cantidadInicio, cantidadFinal, cantidadefectuosas fechainicio, fechaFin, estado)VALUES
        (NULL,  "'.$this->idsegundoModulo.'", "'.$this->idPedido.'", "'.$this->idMaquinaProceso.'", "'.$this->idUsuario.'", "'.$this->idPieza.'", "'.$this->idColor.'", "'.$this->idTalla.'", "'.$this->idPrimerModuloD.'", "'.$this->descripcio.'", "'.$this->cantidadInicio.'", "'.$this->cantidadFinal.'", "'.$this->cantidadefectuosas.'", "'.$this->fechainicio.'", "'.$this->fechaFin.'", "'.$this->estado.'")';
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
            !isset($datos['idPedido']) ||
            !isset($datos['idMaquinaProceso']) ||
            !isset($datos['idUsuario']) ||
            !isset($datos['idPieza']) ||
            !isset($datos['idColor']) ||
            !isset($datos['idTalla']) ||
            !isset($datos['idPrimerModuloD']) ||
            !isset($datos['descripcio']) ||
            !isset($datos['cantidadInicio']) ||
            !isset($datos['cantidadFinal']) ||
            !isset($datos['cantidadefectuosas']) ||
            !isset($datos['fechainicio']) ||
            !isset($datos['fechaFin']) ||
            !isset($datos['estado'])){
                return $respuestas->error_400();
        }else {
            $this->id = $datos['id'];
            $this->idsegundoModulo = $datos['idsegundoModulo'];
            $this->idPedido = $datos['idPedido'];
            $this->idMaquinaProceso = $datos['idMaquinaProceso'];
            $this->idUsuario = $datos['idUsuario'];
            $this->idPieza = $datos['idPieza'];
            $this->idColor = $datos['idColor'];
            $this->idTalla = $datos['idTalla'];
            $this->idPrimerModuloD = $datos['idPrimerModuloD'];
            $this->descripcio = $datos['descripcio'];
            $this->cantidadInicio = $datos['cantidadInicio'];
            $this->cantidadFinal = $datos['cantidadFinal'];
            $this->cantidadefectuosas = $datos['cantidadefectuosas'];
            $this->fechainicio = $datos['fechainicio'];
            $this->fechaFin = $datos['fechaFin'];
            $this->estado = $datos['estado'];

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
        $query = 'UPDATE tercerModulo SET idsegundoModulo= "'.$this->idsegundoModulo.'", idPedido= "'.$this->idPedido.'", idMaquinaProceso= "'.$this->idMaquinaProceso.'", "'.$this->idUsuario.'", descripcio= "'.$this->descripcio.'", cantidadInicio= "'.$this->cantidadInicio.'", cantidadFinal="'.$this->cantidadFinal.'", cantidadefectuosas="'.$this->cantidadefectuosas.'", fechainicio="'.$this->fechainicio.'", fechaFin="'.$this->fechaFin.'", estado="'.$this->estado.'"';
        $res = parent::nonQueryId($query);

        if($res == "ok"){
           return "ok";
        }else{
            return "error";
        }
    }
}