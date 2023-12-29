<?php
namespace App\Repository\RouterRepository;
use App\Factory\DatabaseFactory\DatabaseFactory;
use App\Factory\DatabaseFactory\MysqlDbFactory;
use App\Repository\RouterRepository\RouterRepository;
use App\Repository\Models\Router;
use App\Middleware\Middleware;
use Controllers\PostController;
use Controllers\PutController;
use Controllers\Helper;
use Models\GetModel;

use App\Factory\AccountFactory\AccountFactory;
use App\Strategy\WriterStrategy\SystemWriter;

class PutRouter implements RouterRepository
{
    private $DBconector;
    public function __construct(private Router $router, private Object $APItoken)
    {
        $MysqlFactory = new MysqlDbFactory($this->APItoken->DBparams);
        $MysqlConnector = DatabaseFactory::save($MysqlFactory);
        $this->DBconector = $MysqlConnector;
    }
    public function consistency (): void
    {
        $dbtable = PostController::getColumnsData($this->DBconector, $this->router);
        if($this->router->params == [])             /* En caso no haber parámetros de referencia */
            $this->router->params = Helper::builderQueryParams($this->APItoken->APIkey, 'apikey' )->params;
            // Helper::http($this->router->params, 200);
        $entity  = GetModel::getFilterData($this->DBconector, $this->router);
        $cols    = array_map(fn($c) => $c->item, $dbtable); array_shift($cols);
        foreach (array_keys($this->router->data) as $k => $camp) Helper::notBelong($cols, $camp, 'Propiedades no coinciden');
        $this->router->entity = $entity[0];
    }
    public function getPermission (): void
    {
        Middleware::permissions($this->router, $this->APItoken, $this->DBconector);
    }
    public function Routing (): void 
    {
        $function = $this->router->uri[1] ?? 'update';
        if(in_array($this->router->uri[0], ['accounts', 'emisores'])) {
            $myaccount = AccountFactory::init($this->router, $this->APItoken->APIkey);
            try   { $myaccount -> $function(); }
            catch ( \Throwable $tw) {
                throw new \App\Exception\SystemException($tw);
            }
        }
        PutController::$function(
            $this->DBconector,
            $this->router
        );
    }
}