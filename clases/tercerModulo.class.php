<?php
require_once 'conexion/conexion.php';
require_once 'clases/respuestas.class.php';

class TercerModulo extends Conexion{
    private $id = "";
    private $idsegundoModulo = "";
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
        $query = 'select m.nombre as nombreMaquina, m.idUsuario as encargadoMaquina, sm.idPedido, sm.descripcio, sm.estado, pmd.idPieza, pmd.idColor, pmd.talla, sm.cantidadInicio, sm.cantidadFinal, pmd.colorPrimario, pmd.colorSecundario,
        pmd.colorTerciario, p.nombre as nombrePieza, p.idModelo, mo.nombre as nombreModelo, cp.idColor, c.nombre as NombreColor
        from maquinasProceso mp join maquina m on mp.idMaquina=m.id join primerModulo pm on mp.idPrimerModulo= pm.id join primerModuloDesglose pmd on pm.id=pmd.idPrimerModulo
        join pieza p on pmd.idPieza=p.id join modelo mo on mo.id=p.idModelo join colorPieza cp on cp.id=pmd.idColor join color c on c.id=cp.idColor join segundoModulo sm on sm.idPrimerModulo=pm.id
        where mp.idMaquina="'.$id.'" and pm.estado="1"';

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
        $query = 'INSERT INTO tercerModulo(id, idsegundoModulo, idPedido, idMaquinaProceso, idUsuario, descripcio, cantidadInicio, cantidadFinal, cantidadefectuosas fechainicio, fechaFin, estado)VALUES
        (NULL, "'.$this->id.'", "'.$this->idsegundoModulo.'", "'.$this->idPedido.'", "'.$this->idMaquinaProceso.'", "'.$this->idUsuario.'", "'.$this->descripcio.'", "'.$this->cantidadInicio.'", "'.$this->cantidadFinal.'", "'.$this->cantidadefectuosas.'", "'.$this->fechainicio.'", "'.$this->fechaFin.'", "'.$this->estado.'")';
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
            $this->descripcio = $datos['descripcio'];
            $this->cantidadInicio = $datos['cantidadInicio'];
            $this->cantidadFinal = $datos['cantidadFinal'];
            $this->cantidadefectuosas = $datos['cantidadefectuosas'];
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
        $query = 'UPDATE tercerModulo SET idsegundoModulo= "'.$this->idsegundoModulo.'", idPedido= "'.$this->idPedido.'", idMaquinaProceso= "'.$this->idMaquinaProceso.'", "'.$this->idUsuario.'", descripcio= "'.$this->descripcio.'", cantidadInicio= "'.$this->cantidadInicio.'", cantidadFinal="'.$this->cantidadFinal.'", cantidadefectuosas="'.$this->cantidadefectuosas.'", fechainicio="'.$this->fechainicio.'", fechaFin="'.$this->fechaFin.'", estado="'.$this->estado.'"';
        $res = parent::nonQueryId($query);

        if($res == "ok"){
           return "ok";
        }else{
            return "error";
        }
    }
}