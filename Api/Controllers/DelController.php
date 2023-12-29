<?php
namespace Controllers;
use Models\DelModel;

class DelController{
    public function delData($table, $data){
        $response = DelModel::delData($table, 'id', $data);
        $return = DelController::fncResponse($response, "delData", null);
    }
    public function fncResponse($response, $method, $error){
        if(!empty($response)){
            if(isset($response[0]->password)) unset($response[0]->password);
            $json = array(
                'status' => 200,
                'result' => $response
            );
        }else{
            if($error != null){
                $json = array(
                    'status' => 400,
                    'result'  => $error
                );
            }else{
                $json = array(
                    'status' => 404,
                    'result'  => 'Not found',
                    'method' => $method
                );
            }
        }
        echo json_encode($json, http_response_code($json['status'])); return;
    }
}
