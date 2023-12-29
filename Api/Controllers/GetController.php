<?php
namespace Controllers;
use Models\GetModel;
use App\Resource;
use Controllers\Helper;

class GetController{
    static public function getData($conector, $router)
    {
        $response = GetModel::getData($conector, $router);
        $rs = new GetController();
        $rs->customResponse($response, ":( No se encontró ".$router->table.' buscado');
    }
    static public function find($conector, $router)
    {
        // Helper::HttpResponse(['rs' => $conector], 401);
        $response = GetModel::getFilterData($conector, $router);
        $resource = Resource::getResource($conector, $response);
        $rs = new GetController();
        $rs -> customResponse($resource, ":( No se encontró ".$router->table.' buscado');
    }
    static public function findlike($conector, $router){
        $response = GetModel::getLikeData($conector, $router);
        $resource = Resource::getResource($conector, $response);
        $rs = new GetController();
        $rs -> customResponse($resource, ":( No se encontró un ".$router->table.' parecido');
    }
    static public function filterArrayWithArray($conector, $table, $keyArray, $array) {
        $rs = GetModel::getData($conector, $table);
        $rs = Helper::filterArrayWithArray($rs, $keyArray, $array);
        $return = new GetController();
        return $return -> customResponse($rs, ":'( No se encontraron ".$table." con los parámetros");
    }
    static public function getSince($conector, $table, $key, $ini) {
        $response = GetModel::getSince($conector, $table, $key, $ini);
        $response = Resource::getResource($response);
        $return = new GetController();
        return $return -> customResponse($response, ":( No se encontró ".$table.' buscado');
    }
    public function customResponse($response, $msg)
    {
        if(!empty($response)){
            $json = array(
                'status' => 200,
                'total'  => count($response),
                'body' => $response
            );
        }else{
            $json = array('status' => 404,'total'=> 0,'body'=> $msg);
        }
        echo json_encode($json, http_response_code($json['status']));
    }
}