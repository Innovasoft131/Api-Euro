<?php
require_once 'conexion/conexion.php';
require_once 'clases/respuestas.class.php';

class SegundoModulo extends Conexion{
    private $id = "";
    private $idPrimerModulo = "";
    private $idPedido = "";
    private $idMaquinaProceso = "";
    private $descripcio = "";
    private $idUsuario = "";
    private $cantidadInicio = "";
    private $cantidadFinal = "";
    private $fechainicio = "0000-00-00 00:00:00";
    private $fechaFin = "0000-00-00 00:00:00";
    private $fusion = "";
    private $estado = "";

    public function mostrar($id){
        $respuestas = new Respuestas();
        $query = 'select pm.idPedido, pm.id as idPrimerModulo, pmd.id as idprimerModuloDesglose, mp.id as idmaquinasProceso, pmd.idPieza, p.nombre as NombrePieza, p.idModelo, pmd.idTalla,  mo.nombre as NombreModelo, mp.cantidad, pt.talla as tallaPieza, pmd.idColor, c.nombre as nombreColor, ph.fecha as fechaPedido  from primerModulo pm join primerModuloDesglose pmd on pm.id=pmd.idPrimerModulo join maquinasProceso mp on mp.idPrimerModuloD=pmd.id 
        join piezaTalla pt on pt.id=pmd.idTalla join pieza p on pmd.idPieza = p.id join modelo mo on p.idModelo=mo.id join colorPieza cp on cp.id = pmd.idColor join color c on cp.idColor = c.id join pedidosHechos ph on pm.idPedido=ph.id
        where mp.idMaquina="'.$id.'"';

        $datos = parent::obtenerDatos($query);

        if($datos == null || $datos == ""){
            return $respuestas->error_400("Datos no encontrados");
        }else{
            return $datos;
        }
        
    }

    public function mostrarPrimerModulo($id){
        $query = 'select pm.idPedido, pm.id as idPrimerModulo, pm.descripcion from primerModulo pm join maquinasProceso  mp on mp.idPrimerModulo=pm.id 
        where mp.idMaquina="'.$id.'"';

        $datos = parent::obtenerDatos($query);

        return $datos;
    }

    public function primerModuloDesglose($idPedido,$id){
        $query = 'select pmd.* from primerModuloDesglose pmd join maquinasProceso mp on pmd.id=mp.idPrimerModuloD join primerModulo pm on pm.id=pmd.idPrimerModulo  
        where mp.idMaquina="'.$id.'" and pm.idPedido="'.$idPedido.'"';

     
        $datos = parent::obtenerDatos($query);

        return $datos;
    }

    public function maquina($id){
        $query = 'select nombre from maquina where id="'.$id.'"';

        $datos = parent::obtenerDatos($query);

        return $datos;
    }

    public function modelo($id){
        $query = 'select pm.idPedido, pm.id as idPrimerModulo, pmd.id as idprimerModuloDesglose, mp.id as idmaquinasProceso,  pmd.idModelo, mo.nombre as NombreModelo from primerModulo pm join primerModuloDesglose pmd on pm.id=pmd.idPrimerModulo join maquinasProceso mp on mp.idPrimerModuloD=pmd.id 
        join piezaModelo m on pmd.idModelo = m.id join modelo mo on m.idModelo=mo.id
        where mp.idMaquina="'.$id.'"';



        $datos = parent::obtenerDatos($query);

        return $datos;
    }

    public function color($id){
        $query = ' select distinct c.nombre as nombreColor from color c join colorPieza cp on c.id=cp.idColor 
        where c.id="'.$id.'"';

        $datos = parent::obtenerDatos($query);

        return $datos;
    }


    public function mostrarSegundoModulo($estado){
        $query = 'select pm.id as folio, pm.descripcion, pmd.idPieza, p.nombre as nombrePieza, pmd.idColor, pmd.talla, pmd.cantidad, pm.estado, pmd.colorPrimario, pmd.colorSecundario, pmd.colorTerciario
        from primerModulo pm join primerModuloDesglose pmd on pm.id=pmd.idPrimerModulo join pieza p on pmd.idPieza=p.id Where pm.estado="'.$estado.'"';

        $respuesta = parent::obtenerDatos($query);

        return $respuesta;
    }

    public function obtenerMaquina($idPrimerModulo){
        $query = 'select mp.idMaquina, m.nombre from maquinasProceso mp join maquina m on mp.idPrimerModulo=m.id where idPrimerModulo="'.$idPrimerModulo.'"';

        $respuesta = parent::obtenerDatos($query);

        return $respuesta;
    }

    public function obtenerColor($idPieza){
        $query = 'select c.nombre as nombreColor from color c join colorPieza cp on c.id=cp.idColor where idPieza= "'.$idPieza.'"';

        $respuesta = parent::obtenerDatos($query);

        return $respuesta;
    }

    public function insert($json){
        $respuestas = new Respuestas();
        $datos = json_decode($json, true);

        if(!isset($datos['id']) ||
            !isset($datos['idPrimerModulo']) ||
            !isset($datos['idPedido']) ||
            !isset($datos['idMaquinaProceso']) ||
            !isset($datos['descripcio']) ||
            !isset($datos['idUsuario']) ||
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
            $this->idPedido = $datos['idPedido'];
            $this->idMaquinaProceso = $datos['idMaquinaProceso'];
            $this->descripcio = $datos['descripcio'];
            $this->idUsuario = $datos['idUsuario'];
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
        $query = "INSERT INTO segundoModulo(id, idPrimerModulo, idPedido, idMaquinaProceso, descripcio, idUsuario, cantidadInicio, cantidadFinal, fechainicio, fechaFin, fusion, estado) VALUES".
        "('".$this->id."', '".$this->idPrimerModulo."', '".$this->idPedido."', '".$this->idMaquinaProceso."', '".$this->descripcio."', '".$this->idUsuario."', '".$this->cantidadInicio."', '".$this->fechainicio."', '".$this->fechaFin."', '".$this->fusion."', '".$this->estado."')";
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
            !isset($datos['idPedido']) ||
            !isset($datos['idMaquinaProceso']) ||
            !isset($datos['descripcio']) ||
            !isset($datos['idUsuario']) ||
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
            $this->idPedido = $datos['idPedido'];
            $this->idMaquinaProceso = $datos['idMaquinaProceso'];
            $this->descripcio = $datos['descripcio'];
            $this->idUsuario = $datos['idUsuario'];
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
        $query = 'UPDATE segundoModulo SET idPrimerModulo= "'.$this->idPrimerModulo.'", idPedido="'.$this->idPedido.'", idMaquinaProceso="'.$this->idMaquinaProceso.'", descripcio="'.$this->descripcio.'", idUsuario="'.$this->idUsuario.'", cantidadInicio= "'.$this->cantidadInicio.'", cantidadFinal="'.$this->cantidadFinal.'", fechainicio= "'.$this->fechainicio.'", fechaFin= "'.$this->fechaFin.'", fusion="'.$this->fusion.'", estado="'.$this->estado.'" WHERE id="'.$this->id.'"';
        $res = parent::nonQueryId($query);

        if($res == "ok"){
           return "ok";
        }else{
            return "error";
        }
    }
}