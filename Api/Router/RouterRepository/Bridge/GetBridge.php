<?php
namespace Router\RouterRepository\Bridge;
use App\Factory\DatabaseFactory\DatabaseFactory;
use App\Factory\DatabaseFactory\MysqlDbFactory;
use Router\Models\Router;
use Controllers\Helper;

class GetBridge
{
    static public function getDBconnector($APItoken): object
    {
        $MysqlFactory = new MysqlDbFactory($APItoken->DBparams);
        $MysqlConnector = DatabaseFactory::save($MysqlFactory);
        return $MysqlConnector;
    }
}