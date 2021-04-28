<?php
require_once 'conexion/conexion.php';
require_once 'clases/respuestas.class.php';

class SegundoModulo extends Conexion{
    private $id = "";
    private $idPrimerModulo = "";
    private $idPedido = "";
    private $idMaquinaProceso = "";
    private $idPieza = "";
    private $idColor = "";
    private $idTalla = "";
    private $idPrimerModuloD = "";
    private $descripcio = "";
    private $idUsuario = "";
    private $CantidadRecibida = "";
    private $cantidadInicio = "";
    private $cantidadFinal = "";
    private $fechainicio = "0000-00-00 00:00:00";
    private $fechaFin = "0000-00-00 00:00:00";
    private $fusion = "";
    private $estado = "";

    public function mostrar($id){
        $respuestas = new Respuestas();
        $query = 'select pmd.*, mp.cantidad as cantidad_pieza, c.nombre as color, pt.talla, ph.fecha as fecha_pedido, pm.idPedido, p.nombre as nombre_pieza, m.nombre as nombre_modelo  from primerModulo pm join primermodulodesglose pmd on pmd.idPrimerModulo=pm.id join maquinasproceso mp on mp.idPrimerModuloD=pmd.id
        join colorPieza cp on pmd.idColor = cp.id join color c on c.id = cp.idColor join piezaTalla pt on  pmd.idTalla = pt.id join pedidosHechos ph on ph.id = pm.idPedido
        join pieza p on p.id = pmd.idPieza join modelo m on m.id = p.idModelo
        where mp.idMaquina ="'.$id.'" and ( pm.estado = 1 and mp.estado = 0)';

        $datos = parent::obtenerDatos($query);

        if($datos == null || $datos == ""){
            return $respuestas->error_400("Datos no encontrados");
        }else{
            return $datos;
        }
        
    }

    public function obtenerSegundoModulo($idMaquina){
        $respuestas = new Respuestas();
        $query = 'select sm.*, pt.talla, c.nombre as color, p.nombre as nombre_pieza, m.nombre as nombre_modelo, ph.fecha as fecha_pedido, mp.cantidad as cantidad_maquina, sm.CantidadRecibida from segundoModulo sm join primerModuloDesglose pmd on sm.idPrimerModuloD = pmd.id join primerModulo pm on sm.idPrimerModulo = pm.id join maquinasProceso mp on sm.idMaquinaProceso= mp.id
        join piezaTalla pt on sm.idTalla = pt.id join colorPieza cp on cp.id = sm.idColor join color c on c.id = cp.idColor join pieza p on p.id = sm.idPieza join modelo m on m.id = sm.idPieza
        join pedidosHechos ph on ph.id = sm.idPedido
        where mp.idMaquina ="'.$idMaquina.'" and (pm.estado = 1 and mp.estado = 1 and sm.estado = 0)';

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
        $query = 'select sm.idMaquinaProceso, sm.idPrimerModulo from segundoModulo sm join primerModulo pm on pm.id=sm.idPrimerModulo where sm.estado= '.$estado.' and pm.estado = 1';

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
            !isset($datos['idPieza']) ||
            !isset($datos['idColor']) ||
            !isset($datos['idTalla']) ||
            !isset($datos['idPrimerModuloD']) ||
            !isset($datos['descripcio']) ||
            !isset($datos['idUsuario']) ||
            !isset($datos['CantidadRecibida']) ||
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
            $this->idPieza = $datos['idPieza'];
            $this->idColor = $datos['idColor'];
            $this->idTalla = $datos['idTalla'];
            $this->idPrimerModuloD = $datos['idPrimerModuloD'];
            $this->descripcio = $datos['descripcio'];
            $this->idUsuario = $datos['idUsuario'];
            $this->CantidadRecibida = $datos['CantidadRecibida'];
            $this->cantidadInicio = $datos['cantidadInicio'];
            $this->cantidadFinal = $datos['cantidadFinal'];
            $this->fechainicio = $datos['fechainicio'];
            $this->fechaFin = $datos['fechaFin'];
            $this->fusion = $datos['fusion'];
            $this->estado = $datos['estado'];

            $res = $this->insertar();

            
            if($res > 0){
                $respuesta = $respuestas -> response;
                    $respuesta['result'] = array(
                        "idPrimerModulo" => $this->idPrimerModulo,
                        "idSegundoModulo" => $res,
                        "resultado" => "Guardado"
                    );
                    return $respuesta;
            }else {
                return $respuestas->error_500();
            }
        }
    }

    private function insertar(){
        if($this->descripcio == null || $this->descripcio == "" || $this->fechaFin == null || $this->fechaFin == "" || $this->fusion == null || $this->fusion == ""){
            $query = "INSERT INTO segundoModulo(id, idPrimerModulo, idPedido, idMaquinaProceso, idPieza, idColor, idTalla, idPrimerModuloD, descripcio, idUsuario, CantidadRecibida, cantidadInicio, cantidadFinal, fechainicio, fechaFin, fusion, estado) VALUES".
            "(null, ".$this->idPrimerModulo.", ".$this->idPedido.", ".$this->idMaquinaProceso.", ".$this->idPieza.", ".$this->idColor.", ".$this->idTalla.", ".$this->idPrimerModuloD.", null, ".$this->idUsuario.", ".$this->CantidadRecibida.",  ".$this->cantidadInicio.", ".$this->cantidadFinal.", now(), null, null, '".$this->estado."'  )";
        }else{
            $query = "INSERT INTO segundoModulo(id, idPrimerModulo, idPedido, idMaquinaProceso, idPieza, idColor, idTalla, idPrimerModuloD, descripcio, idUsuario, CantidadRecibida, cantidadInicio, cantidadFinal, fechainicio, fechaFin, fusion, estado) VALUES".
            "(null, ".$this->idPrimerModulo.", ".$this->idPedido.", ".$this->idMaquinaProceso.",  ".$this->idPieza.", ".$this->idColor.", ".$this->idTalla.", ".$this->idPrimerModuloD.", '".$this->descripcio."', ".$this->idUsuario.", ".$this->CantidadRecibida.",  ".$this->cantidadInicio.", ".$this->cantidadFinal.", '".$this->fechainicio."', '".$this->fechaFin."', '".$this->fusion."', '".$this->estado."'  )";
        }
      
        $res = parent::nonQueryIds($query);


        return $res;
    }


    public function edit($json){
        $respuestas = new Respuestas();
        $datos = json_decode($json, true);

        if(!isset($datos['id']) ||
            !isset($datos['idPrimerModulo']) ||
            !isset($datos['idPedido']) ||
            !isset($datos['idMaquinaProceso']) ||
            !isset($datos['idPieza']) ||
            !isset($datos['idColor']) ||
            !isset($datos['idTalla']) ||
            !isset($datos['idPrimerModuloD']) ||
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
            $this->idPieza = $datos['idPieza'];
            $this->idColor = $datos['idColor'];
            $this->idTalla = $datos['idTalla'];
            $this->idPrimerModuloD = $datos['idPrimerModuloD'];
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
        $query = 'UPDATE segundoModulo SET idPrimerModulo= "'.$this->idPrimerModulo.'", idPedido="'.$this->idPedido.'", idMaquinaProceso="'.$this->idMaquinaProceso.'", idPieza="'.$this->idPieza.'", idColor="'.$this->idColor.'", idTalla="'.$this->idTalla.'", idPrimerModuloD="'.$this->idPrimerModuloD.'", descripcio="'.$this->descripcio.'", idUsuario="'.$this->idUsuario.'", cantidadInicio= "'.$this->cantidadInicio.'", cantidadFinal="'.$this->cantidadFinal.'", fechainicio= "'.$this->fechainicio.'", fechaFin= "'.$this->fechaFin.'", fusion="'.$this->fusion.'", estado="'.$this->estado.'" WHERE id="'.$this->id.'"';
        $res = parent::nonQueryId($query);

        if($res == "ok"){
           return "ok";
        }else{
            return "error";
        }
    }
}