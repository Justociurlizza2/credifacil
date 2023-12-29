<?php
namespace Controllers;
use Firebase\JWT\JWT;
use Models\GetModel;
use Models\PostModel;
use Models\PutModel;
use Controllers\Helper;
/* Factory */
use App\Factory\DatabaseFactory\DatabaseFactory;
use App\Factory\DatabaseFactory\MysqlDbFactory;

class PostController{
    public function postXML($nombre, $data) {
        $nombre = base64_decode($nombre);
        $emisor = json_decode($data["emisor"], true);
        $folderXML = GeneradorXML::CrearXMLFactura($nombre, $data);
        // $json = array(
        //     'status' => 400,
        //     'result' => $emisor['usuario_sol_sec']
        // );echo json_encode($json, http_response_code($json['status'])); return;
        $enviarSunat = ApiFacturacion::EnviarComprobanteElectronico($emisor, $nombre, "", $folderXML, "cdr/".$folderXML);
        // $return = PostController::fncResponse($enviarSunat, 'postXML', null);
        $return = PostController::fncResponse($enviarSunat, 'postXML', null);
    }
    public function bajaXML($nombre, $data) {
        $nombre = base64_decode($nombre);
        $emisor = json_decode($data["emisor"], true); $cabecera = json_decode($data["compro"], true);
        $folderXML = GeneradorXML::CrearXmlBajaDocumentos($nombre, $data);
        $enviarSunat = ApiFacturacion::EnviarResumenComprobantes($emisor, $nombre, "", $folderXML);
        $getTicket = ApiFacturacion::ConsultarTicket($emisor, $cabecera, $enviarSunat, "cdr/");
        $return = PostController::fncResponse($getTicket, 'postXML', null);
    }
    public function resumenXML($nombre, $data) {
        $nombre = base64_decode($nombre);
        $emisor = json_decode($data["emisor"], true); $cabecera = json_decode($data["compro"], true);
        $folderXML = GeneradorXML::CrearXMLResumenDocumentos($nombre, $data);
        $enviarSunat = ApiFacturacion::EnviarResumenComprobantes($emisor, $nombre, "", $folderXML);
        $getTicket = ApiFacturacion::ConsultarTicket($emisor, $cabecera, $enviarSunat, "cdr/");
        $return = PostController::fncResponse($getTicket, 'postXML', null);
    }
    public function notaXML($nombre, $type, $data) {
        $nombre = base64_decode($nombre);
        $emisor = json_decode($data["emisor"], true);
        $type === 'C' ? $folderXML = GeneradorXML::CrearXMLNotaCredito($nombre, $data) : 
        $folderXML = GeneradorXML::CrearXMLNotaDebito($nombre, $data);
        $enviarSunat = ApiFacturacion::EnviarComprobanteElectronico($emisor, $nombre, "", "", "cdr/");
        $return = PostController::fncResponse($enviarSunat, 'noteXML', $enviarSunat);
    }


    static public function postData($conector, $router)
    {
        $response = PostModel::postData($conector, $router);
        $return = PostController::fncResponse($response, "postData", null);
    }
    public function postRegister($table, $data){
        if(isset($data['password']) && $data['password'] != null){
            $crypt = crypt($data['password'], '$2a$07$byxqpwe4x781sdsty88p$');
            $data['password'] = $crypt;
            $response = PostModel::postData($table, $data);
            $return = PostController::fncResponse($response, "postRegister", null);
        }
    }
    static function postLogin($table, $router) {   
        $router->table = $table;
        $router->params = [ 'link'  => 'usuario', 'equal' => $router->data['usuario'] ];
        // $dbname = isset($router->data['ruc']) ? 'bret'.$router->data['ruc'] : 'api.pe.bretsia';

        $MysqlFactory = new MysqlDbFactory();
        $MysqlConnector = DatabaseFactory::save($MysqlFactory);
        $response = GetModel::getFilterData($MysqlConnector, $router);
        $crypt = crypt($router->data['password'], '$2a$07$usesomesillystringforsalt$');
        if(empty($response))                  Helper::http($router->params['link'].' no registrado');
        if($response[0]->password !== $crypt) Helper::http('Password errónea');

        $time = time();
        $key = 'kejwak4e5r2fet4xyzdmfl49e308';
        $token = array(
            'iat' => $time,
            "exp" => $time + (14400*4),
            'data' => [
                'id'     => $response[0]->id,
                'access' => $table
            ]
        );
        $jwt = JWT::encode($token, $key);
        $router->data = array( 'token' => $jwt, 'ultimo_login' => date('Y-m-d H:i:s'));
        PutModel::update($MysqlConnector, $router);
        Helper::http($jwt, 200);
    }
    static public function fncResponse($response, $method, $error){
        if(!empty($response)){
            if(isset($response[0]->password)) unset($response[0]->password);
            $json = array(
                'status' => 200,
                'result' => $response
            );
        }else{
            if($error != null){
                $json = array(
                    'status' => 401,
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
        echo json_encode($json, http_response_code($json['status'])); exit;
    }
    static public function getColumnsData($conector, $router)
    {
        return PostModel::getColumnsData($conector, $router);
    }
}