<?php
namespace Router\RouterRepository\Bridge;
use App\Factory\DatabaseFactory\DatabaseFactory;
use App\Factory\DatabaseFactory\MysqlDbFactory;
use Router\Models\Router;
use Controllers\Helper;

class PostBridge
{
    static public function getInstance($router): string
    {
        if(in_array($router->uri[0], ['creditos'])) {
            return match ($router->uri[0]) {
                'creditos'   => 'App\\Repository\\'
            };
        }
        if(in_array($router->uri[0], ['cuotas'])) {
            return match ($router->uri[0]) {
                'cuotas'   => 'App\\Factory\\CuotaFactory\\CuotaFactory'
            };
        }
        if(in_array($router->uri[0], ['pagos'])) {
            return match ($router->uri[0]) {
                'pagos'     => 'App\\Pago'
            };
        }
        return '';
    }
    static public function getDBconnector($APItoken): object
    {
        $MysqlFactory = new MysqlDbFactory($APItoken->DBparams);
        $MysqlConnector = DatabaseFactory::save($MysqlFactory);
        return $MysqlConnector;
    }
}