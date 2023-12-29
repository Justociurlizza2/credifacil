<?php
namespace App\Middleware;
use Firebase\JWT\JWT;
use App\Auth;
use Models\GetModel;
use Controllers\Helper;

class Middleware { 
    static public function profile($jwt, $table) {
        if($table === 'profile') {
            $access = $jwt->data->access;
            $token = JWT::encode($jwt, 'kejwak4e5r2fet4xyzdmfl49e308');
            $user = GetModel::getFilterData($access, 'token', $token, null)[0];
            if(empty($user) && time() < $jwt->exp) Helper::HttpResponse(['rs' =>'Acceso prohibido a recurso'], 403);
            $user = Helper::deleteKeys($user, ['token', 'password']);
            Helper::HttpResponse(['rs' => $user], 200); exit;
        }
    } 

    static public function ownership($req, $jwt) {
        $req = json_decode(json_encode($req));
        $user = GetModel::getFilterData($jwt->data->access, 'id', $jwt->data->id, null)[0];
        // if($jwt->data->profile === 'Administrador') return;  ( aplicaría para el dueño )
        if(!isset($req->idu) && !isset($req->idsuc)) return;
        if(isset($req->idu) && $req->idu !== $jwt->data->id) {
            if(isset($req->idu_r)) return;  // Si gestiona un receptor
            Helper::HttpResponse(['rs' =>'No puede manipular un registro de su no-autoría'], 405);
        }
        Helper::notBelong(json_decode($user->tiendas), $req->idsuc, 'No está habilitado en la sucursal elegida');
    }
    static public function permissions($router, $APItoken, $DBconector) {
        if(in_array($router->table, ['profile'])) return;
        // helper::http($APItoken->APItoken->data->access);
        $params = (Object) [
            "table" => $APItoken->APItoken->data->access,
            "params"=> [ "link"  => 'id', "equal" => $APItoken->APItoken->data->id ]
        ];
        $user = GetModel::getFilterData($DBconector, $params)[0];
        // Helper::HttpResponse(['rs' => $user]);
        $roles   = json_decode($user->roles, true);
        $modules = array_keys($roles);
        Helper::notBelong ($modules, $router->table, 'Denied access for module: '. $router->table);
        $permission = $roles[$router->table][$router->method];
        if($permission === 0) Helper::HttpResponse(['rs'=> 'Permission denied (usuario con acceso restringido)'], 400);
    }
    // static public function permissions($method, $table, $jwt) {
    //     if(in_array($table, ['profile'])) return;
    //     $user    = GetModel::getFilterData($jwt->data->access, 'id', $jwt->data->id, null)[0];
    //     $roles   = json_decode($user->roles, true);
    //     $modules = array_keys($roles);
    //     Helper::notBelong ($modules, $table, 'Denied access for module: '. $table);
    //     $permission = $roles[$table][$method];
    //     if($permission === 0) Helper::HttpResponse(['rs'=> 'Permission denied (usuario con acceso restringido)'], 400);
    // }
}