<?php
namespace App\Factory\AccountFactory;
use App\Middleware\Encryption;
use Controllers\Helper;
use Models\GetModel;
/* Dbconnection */
use App\Factory\DatabaseFactory\DatabaseFactory;
use App\Factory\DatabaseFactory\MysqlDbFactory;

abstract class AccountFactory
{
    abstract public function getBusinessManager(): IBusinessManager;

    static public function init( $router, Object $APIkey = new \stdClass()): IBusinessManager
    {
        $plan = self::getPlan($APIkey);
        // Helper::HttpResponse(['rs' => $plan]);
        $instance = "App\\Factory\\AccountFactory\\". $plan."Factory";
        $accountFactory = new $instance($router, $APIkey);
        $businessManager = $accountFactory->getBusinessManager();
        return $businessManager;
    }
    
    static private function getPlan ($APIkey): string
    {
        if($APIkey ==  new \stdClass()) return 'Standard';
        $DBparams = [ 'handler' => 'mysql', 'host' => 'localhost', 'dbname' => 'credifacil' ];
        $params = (Object) [
            "table" => 'accounts',
            "params"=> [ "link"  => 'apikey', "equal" => $APIkey->apikey ]
        ];
        $MysqlFactory = new MysqlDbFactory($DBparams);
        $MysqlConnector = DatabaseFactory::save($MysqlFactory);
        $account = GetModel::getFilterData($MysqlConnector, $params)[0];
        return match ($account->plan) {
            1 => 'Standard',
            2 => 'Premium',
        };
    }
}