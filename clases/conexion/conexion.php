<?php 

class Conexion{
    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $conexion;

    
    function __construct(){
        $listadatos = $this->datosConexion();
        foreach ($listadatos as $key => $value) {
            $this->server = $value['server'];
            $this->user = $value['user'];
            $this->password = $value['password'];
            $this->database = $value['database'];
            $this->port = $value['port'];
        }
        

        try {
            $this->conexion = new PDO("mysql:host=".$this->server.";dbname=".$this->database, $this->user, $this->password);
            $this->conexion->exec("set names utf8");
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }
        

        return $this->conexion;

    }
    



    private function datosConexion(){
        $direccion = dirname(__FILE__);
        $jsondata = file_get_contents($direccion."/"."config");
        return json_decode($jsondata, true);
    }

    private function convertirUTF8($array){
        array_walk_recursive($array,function(&$item, $key){
            if(!mb_detect_encoding($item,'utf-8',true)){
                $item = utf8_encode($item);
            }
        });

        return $array;
    }

    public function obtenerDatos($sqlString){
        $results = $this->conexion->prepare($sqlString);
        $results->execute();
        $resultados = $results->fetchAll();

        $resultArray = array();

        foreach ($resultados as $key ) {
            $resultArray[] = $key;
        }


        return $this->convertirUTF8($resultArray);
        $results->close();
        $results = null;
    }

    public function nonQuery($sqlString){
        $results = $this->conexion->prepare($sqlString);
        $results->execute();
        $resultados = $results->rowCount();
        return $resultados;
        $results->close();
        $results = null;

    }

    // es para insertar
    public function nonQueryId($sqlString){
        $results = $this->conexion->prepare($sqlString);
        
     //   $filas = $results->rowCount();

        if($results->execute()){
            return "ok";
        }else{
            return "error";
        }

        $results->close();
        $results = null;

    }

    public function nonQueryIds($sqlString){

        $cn = $this->conexion;
        $results = $cn->prepare($sqlString);
        
     

        
        if($results->execute()){
            $filas = $cn->lastInsertId();
            return $filas;
        }else{
            return "error";
        }

        $results->close();
        $results = null;

    }

    // encriptar

    protected function encriptar($password){
        return $encriptar = crypt($password, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
    }
}