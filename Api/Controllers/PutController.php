<?php
namespace Controllers;
use Models\GetModel;
use Models\PutModel;

class PutController {
    static public function update ($conector, $router) 
    {
        $response = PutModel::update($conector, $router);
        $return = PutController::fncResponse($response, "update", null);
    }
    static public function fncResponse($response, $method){
        if($response == "The process was successful") Helper::http($response, 200);
        Helper::http($response, 400);
    }
}