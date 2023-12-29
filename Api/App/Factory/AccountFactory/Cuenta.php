<?php
namespace App\Factory\AccountFactory;
use App\Factory\AccountFactory\IBusinessEntity;
use App\Factory\DatabaseFactory\DatabaseFactory;
use App\Factory\DatabaseFactory\MysqlDbFactory;
use App\Factory\AccountFactory\Emisor;
use Models\PutModel;
use Models\GetModel;
use App\Middleware\APIkey;
use App\Middleware\Encryption;
use Controllers\PostController;
use Controllers\PutController;
use Controllers\Helper;

class Cuenta implements IBusinessEntity
{
    private Object $DBconnector;
    public function __construct(public $router, public $APIkey)
    {
        if($APIkey->access !== 'accounts') helper::http('APIkey no pertenece a una cuenta', 403);
        $this->DBconnector = DatabaseFactory::save(new MysqlDbFactory());
    }
    public function create (): void
    {
        $data = $this->router->data;
        Helper::avoidEmpty($data, ['usuario','password']);
        $body = array('cu'=>$data['usuario']);  /* params to encode ApiKey */
        $user['usuario'] = $data['usuario'];
        $user['password']= crypt($data['password'], '$2a$07$usesomesillystringforsalt$');
        $user['apikey']  = Encryption::Encode(json_encode($body), 'api.pe.key');
        $this->router->data = $user;
        PostController::postData($this->DBconnector, $this->router);
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
        $APIkey = new APIkey($this->router->data['apikey']);
        $emisor = new Emisor($this->router, $APIkey->getApiKeyToken());
        $emisores = json_decode($this->router->entity->emisores, true);
        in_array($APIkey->getApiKeyToken()->ruc, $emisores) ? 
            helper::http('El emisor '. $APIkey->getApiKeyToken()->ruc.' ya está asociado a su cuenta.') :
            $emisores[] = $APIkey->getApiKeyToken()->ruc;
        /* Asociamos el nuevo emisor */
            $this->router->data = [ "emisores" => json_encode($emisores)];
            $this->router->params = [ "link"  => 'apikey', "equal" => $this->APIkey->apikey ];
            PutModel::update($this->DBconnector, $this->router);
        /* Actualizamos el apikey del emisor */
            $body = array('cu' => $this->APIkey->cuenta, 'ruc'=> $APIkey->getApiKeyToken()->ruc);
            $this->router->params = [ "link"  => "ruc", "equal" => $APIkey->getApiKeyToken()->ruc ];
            $this->router->data = [ "apikey" => $APIkey->buildApiKey($body) ];
            $this->router->table = 'emisores';
            PutController::update($this->DBconnector, $this->router);
    }
    public function migrate (): void
    {
        $this->router->params = [ "link"  => 'apikey', "equal" => $this->APIkey->apikey ];
        PutController::update($this->DBconnector, $this->router);
    }
}