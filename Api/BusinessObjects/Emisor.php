<?php
namespace BusinessObjects;
use Firebase\JWT\JWT;
use Bash\Bash;
use Services\InfoPersona;
use Models\GetModel;
use Models\PostModel;
use Controllers\Helper;
use Controllers\PostController;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Message;
use GuzzleHttp\Client;
use App\Middleware\Encryption;

use App\Factory\DatabaseFactory\DatabaseFactory;
use App\Factory\DatabaseFactory\MysqlDbFactory;

class Emisor {
    static public function newEmisor ($router) {
        /********** Generación de APIKey **********/
        $data = $router->data;
        Helper::avoidEmpty($data, ['ruc','password']);
        $DBparams = ['handler'=> 'mysql','host'=> 'localhost','dbname'=> 'api.pe.bretsia'];
        $MysqlFactory = new MysqlDbFactory($DBparams);
        $MysqlConnector = DatabaseFactory::save($MysqlFactory);
        /********** Consultamos y seteamos contribuyente **********/
        $emisor= InfoPersona::consultarRUC($data['ruc']);
        $dbtab = PostController::getColumnsData($MysqlConnector, $router);
        if($emisor['status'] == 401) Helper::HttpResponse(['rs' => $emisor['rs']]);
        $router->data = Helper::DeleteKeys($emisor['rs'], array_map(fn($c) => $c->item, $dbtab), 1);
        /********** Clonamos bretsiadb con Bash **********/
        if(!Bash::cloneDB($data)) Helper::HttpResponse(['rs' => 'Error: Servicio posiblemente ya existe con ese RUC.']);
        PostModel::postData($MysqlConnector, $router);
        /********** Registramos usuario en el servicio **********/
        $MysqlConnector->setSettings([
            'handler'=> 'mysql','host'=> 'localhost','dbname'=> "bret".$data["ruc"]
        ]);
        $user['nombre']  = "Emisor - ".$data["ruc"];
        $user['usuario'] = 'admin';
        $user['password']= crypt($data['password'], '$2a$07$usesomesillystringforsalt$');
        $user['perfil']  = 'Administrador';
        $user['apikey']  = Encryption::Encode($MysqlConnector->dbname, 'api.pe.key');
        $router->data    = $user;
        $router->table   = 'usuarios';
        PostController::postData($MysqlConnector, $router);
    }
}    
// static public function newEmisor ($data) {
//     /********** Generación de APIKey **********/
//     Helper::avoidEmpty($data, ['ruc','password']);
//     $cnx = ['handler'=> 'mysql','host'=> 'localhost','dbname'=> 'api.pe.bretsia'];
//     /********** Consultamos y seteamos contribuyente **********/
//     $emisor= InfoPersona::consultarRUC($data['ruc']);
//     $dbtab = PostController::getColumnsData($cnx, 'emisores', $cnx['dbname']);
//     if($emisor['status'] == 401) Helper::HttpResponse(['rs' => $emisor['rs']]);
//     $emisor = Helper::DeleteKeys($emisor['rs'], array_map(fn($c) => $c->item, $dbtab), 1);
//     /********** Clonamos bretsiadb con Bash **********/
//     if(!Bash::cloneDB($data)) Helper::HttpResponse(['rs' => 'Error: Servicio posiblemente ya existe con ese RUC.']);
//     PostModel::postData($cnx, 'emisores', $emisor);
//     /********** Registramos usuario en el servicio **********/
//     $cnx['dbname']   = 'bret'.$data['ruc'];
//     $user['nombre']  = 'Emisor - '.$data['ruc'];
//     $user['usuario'] = 'admin';
//     $user['password']= crypt($data['password'], '$2a$07$usesomesillystringforsalt$');
//     $user['perfil']  = 'Administrador';
//     $user['apikey']  = Encryption::Encode($cnx['dbname'], 'api.pe.key');
//     // Helper::HttpResponse(['rs' => $cnx]);
//     PostController::postData($cnx, 'usuarios', $user); exit;
// }