<?php 
class Respuestas{
    public $response = [
        'status' => 'ok',
        'result' => array()
    ];

    public function error_405(){
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            'error_id' => '405',
            'error_smg' => 'Metodo no permitido'
        );
        return $this->response;
    }


    public function error_200($string = "Datos Incorrectos"){
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            'error_id' => '200',
            'error_smg' => $string
        );
        return $this->response;
    }

    public function error_400($string = "Datos enviados incompletos o con formato incorrecto"){
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            'error_id' => '400',
            'error_smg' => $string
        );
        return $this->response;
    }

    public function error_500($string = "Error interno del servidor"){
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            'error_id' => '500',
            'error_smg' => $string
        );
        return $this->response;
    }
}