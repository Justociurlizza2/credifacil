<?php 
namespace Controllers;
use Firebase\JWT\JWT;
use Models\GetModel;

class Helper {
    static public function httpResponse ($body, $status = 400) {
        $body['body'] = $body['rs']; unset($body['rs']);
        $body['status'] = $status;
        echo json_encode($body, http_response_code($body['status']));
        if($status > 399) exit;
    }
    static public function http ($body, $status = 400, $exit = true): void 
    {
        $http = [];
        $http['status'] = $status;
        is_array($body && isset($body['body']))? $http = array_merge($http, $body) : $http['body'] = $body;
        echo json_encode($http, http_response_code($http['status']));
        if($exit) exit;
    }
    static public function builderQueryParams (object $Object, string $key): object
    {
        return (object) [
            'table' => $Object->table?? $Object->access,
            'params'=> [ 'link'  => $key, "equal" => $Object->data[$key]?? $Object->$key ],
            'data'  => $Object->data?? []
        ];
    }
    static public function deleteKeys ($data, $keys, $sig = 0) {    /* 0 => borra coincidencias, 1 => borra no-iguales */
        $data = json_decode(json_encode($data), true);
        foreach (array_keys($data) as $k) {
            if($sig == 0) if( in_array($k, $keys)) { unset($data[$k]); }
            if($sig == 1) if(!in_array($k, $keys)) { unset($data[$k]); }
        }
        return $data;
    }
    static public function avoidNegative($data) {

    }
    static public function avoidEmpty($data, $keys) {
        foreach ($keys as $k) {
            if(!in_array($k, array_keys($data)))        Helper::http('Se requiere de: '.$k);
            if(empty($data[$k]) || $data[$k] == '[]')   Helper::http($k.': está vacío');
            if($data[$k] === 0 || !isset($data[$k]))    Helper::http($k.': No asginado o es inválido'); 
        }
    }
    static public function notBelong ($array, $elem, $msg) {
        if(!in_array($elem, $array)) Helper::http($msg.':[ '.$elem.' ]', 405);
    }
    static public function multiEncode($body, $keys) {
        foreach ($keys as $k => $key_to_encode) {
            $encoded_value = json_encode($body[$key_to_encode]);
            $body[$key_to_encode] = $encoded_value;
        }
        return $body;
    }
    static public function routeTimestamp ($path, $ext = '') : string
    {
        $path = explode('/', $path);
        $name = array_pop($path);
        $time = date('d-m-y H:i:s');
        $time = str_replace(':', '', $time);
        $time = str_replace('-', '', $time);
        $title = $name.str_replace(' ', '_', $time);
        $path = implode('/', $path);
        return $path.'/'. $title. $ext;
    }
}