<?php
namespace App\Factory\AccountFactory;
use App\Factory\AccountFactory\IBusinessEntity;
use App\Factory\DatabaseFactory\DatabaseFactory;
use App\Factory\DatabaseFactory\MysqlDbFactory;
use App\Middleware\Encryption;
use Models\PostModel;
use Controllers\PostController;
use Controllers\PutController;
use Controllers\Helper;
/* Personal Libraries */
use Services\InfoPersona;
use Firebase\JWT\JWT;
use Bash\Bash;

class Emisor implements IBusinessEntity
{
    private Object $DBconnector;
    public function __construct(public $router, public $APIkey)
    {
        if($router->uri[1] == 'create') return;
        if($APIkey->access !== 'emisores') helper::http('APIkey no pertenece a un emisor', 402);
        $MysqlFactory = new MysqlDbFactory(['dbname' => $APIkey->dbname], 'BRET');
        $this->DBconnector = DatabaseFactory::save($MysqlFactory);
    }
    public function create (): void
    {
        /*---------------------- Consultamos contribuyente ----------------------*/
        $data = $this->router->data;
        Helper::avoidEmpty($data, ['ruc','password']);
        $emisor= InfoPersona::consultarRUC($data['ruc']);
        if($emisor['status'] == 401) Helper::http($emisor['rs'], 401);
        $MysqlFactory = new MysqlDbFactory();
        $MysqlConnector = DatabaseFactory::save($MysqlFactory);
        $dbtab = PostController::getColumnsData($MysqlConnector, $this->router);
        $this->router->data = Helper::DeleteKeys($emisor['rs'], array_map(fn($c) => $c->item, $dbtab), 1);

        /*---------------------- Clonamos bretsiadb con Bash ----------------------*/
        if(!Bash::cloneDB($data)) Helper::HttpResponse(['rs' => 'Error: Servicio posiblemente ya existe con ese RUC.']);
        $body = array ('cu' =>'', 'ruc'=> $data['ruc']);  /* params to encode ApiKey */
        $apikey = Encryption::encode(json_encode($body), 'api.pe.key');
        $this->router->data['apikey'] = $apikey;
        PostModel::postData($MysqlConnector, $this->router);

        /*----------------- Registramos usuario en el servicio DB -----------------*/
        $MysqlConnector->setSettings(['dbname'=> "bret".$data["ruc"]]);
        $user['nombre']     = "Emisor - ".$data["ruc"];
        $user['usuario']    = 'admin';
        $user['perfil']     = 'Administrador';
        $user['password']   = crypt($data['password'], '$2a$07$usesomesillystringforsalt$');
        $user['apikey']     = $apikey;
        $this->router->table= 'usuarios';
        $this->router->data = $user;
        PostController::postData($MysqlConnector, $this->router);
    }
    public function suspend (): void
    {
        $this->router->params = [ "link"  => 'apikey', "equal" => $this->APIkey->apikey ];
        PutController::update($this->DBconnector, $this->router);
    }
    public function activate (): void
    {
        $this->router->params = [ "link"  => 'apikey', "equal" => $this->APIkey->apikey ];
        PutController::update($this->DBconnector, $this->router);
    }
    public function asociar (): void
    {
        // Helper::http($this->router);
        $this->router->params = [ "link"  => 'apikey', "equal" => $this->APIkey->apikey ];
        PutController::update($this->DBconnector, $this->router);
    }
    public function migrate (): void
    {
        $this->router->params = [ "link"  => 'apikey', "equal" => $this->APIkey->apikey ];
        PutController::update($this->DBconnector, $this->router);
    }
}