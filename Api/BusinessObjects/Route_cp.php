<?php
use Firebase\JWT\JWT;
use App\Auth;
use App\Middleware;
use BusinessObjects\Emisor;
use Controllers\GetController;
use Controllers\PostController;
use Controllers\PutController;
use Controllers\DelController, Controllers\RouteController;
use Controllers\Helper;

$endPoint = array_filter(explode("/", $_SERVER['REQUEST_URI']));
if (count($endPoint) == 0) Helper::HttpResponse(['rs' => 'Welcome to Api Bretsia'], 400);
if (count($endPoint) !== 1 || !isset($_SERVER['REQUEST_METHOD'])) return;

$table = explode("?", $endPoint[1])[0];
$data = array(); // parse_str(file_get_contents('php://input'), $data);
$data = json_decode(file_get_contents('php://input'), true);

if(isset($_GET['login'])) { PostController::postLogin('usuarios', $data, 'usuario'); exit;}
if($table == 'emisores')  Emisor::newEmisor($data);              /***** Para nuevos emisores *****/

if ($_SERVER['REQUEST_METHOD']=="GET") {
    if(isset($_GET['link']) && isset($_GET['equal'])) {
        isset($validate) ? $valid = $validate['result'] : $valid = null;
        Middleware::profile($valid, $table);
        echo GetController::getFilterData($table, $_GET['link'], $_GET['equal']);
    } 
    else if(isset($_GET['like']) && isset($_GET['equal'])) {
        echo GetController::getLikeData($table, $_GET['like'], $_GET['equal']);
    }
    else { echo GetController::getData($table); }
}
if ($_SERVER['REQUEST_METHOD']=="POST") {
    $db = RouteController::db(); $cols = array();
    $dbtab = PostController::getColumnsData($table, $db);
    foreach ($dbtab as $key => $field) {array_push($cols, $field->item); } unset($cols->id);
    foreach (array_keys($data) as $key => $camp) { Helper::notBelong($cols, $camp, 'Params do not match'); }
    isset($data['usuario']) ? $param = "usuario" : $param = "rfc";
    if(isset($_GET['register']))      PostController::postRegister($table, $data, $param);
    else if(isset($_GET['credential'])) {
        Middleware::ownership($data, $validate['result']);
        switch($table) {
            case 'compras'  : Compra::postData  ($table, $data, $validate['result']); break;
            case 'ventas'   : Venta::postData   ($table, $data, $validate['result']); break;
            case 'traslados': Traslado::postData($table, $data, $validate['result']); break;
            default: PostController::postData($table, $data);
        }
    } else { Helper::HttpResponse(['rs' => 'Error: Invalid procedure'], 405); }
}
if ($_SERVER['REQUEST_METHOD']=="PUT") {
    if (!isset($_GET['id']) || !isset($_GET['nameId'])) Helper::HttpResponse(['rs' => 'Especify values'], 400);
    $res = GetController::getFilterData($table, $_GET['nameId'], $_GET['id']);
    if (json_decode($res)->status !== 200) Helper::httpResponse(['rs'=> json_decode($res)->result], 401);
    Middleware::ownership(json_decode($res)->result[0], $validate['result']);

    $db = RouteController::db(); $cols = array();
    $dbtab = PostController::getColumnsData($table, $db);
    $cols = array_map(fn($c) => $c->item, $dbtab);  // unset($cols->id);
    foreach (array_keys($data) as $key => $camp) { Helper::notBelong($cols, $camp, 'Params do not match'); } 
    switch($table) {
        case "compras"      : Compra::switch($data, $validate['result'], $_GET['type'], $res); break;
        case "ventas"       : Venta::switch ($data, $validate['result'], $_GET['type'], $res); break;
        case "traslados"    : Traslado::switch($data, $validate['result'], $_GET['type'], $res); break;
        default             : PutController::update($table, $data, $_GET['nameId'], $_GET['id']);
    }
}
if ($_SERVER['REQUEST_METHOD']=="DELETE") {
    if(isset($_GET['destroy']) && $_GET['destroy'] !== null) DelController::delData($table, $_GET['destroy']);
}