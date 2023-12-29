<?php
namespace App\Repository\RouterRepository;
use App\Repository\RouterRepository\RouterRepository;
use App\Factory\DatabaseFactory\DatabaseFactory;
use App\Factory\DatabaseFactory\MysqlDbFactory;
use App\Repository\Models\Router;
use App\Middleware\Middleware;
use Controllers\GetController;
use Controllers\Helper;

class GetRouter implements RouterRepository
{
    private $DBconector;
    public function __construct(private Router $router, private $APItoken)
    {
        $MysqlFactory = new MysqlDbFactory($this->APItoken->DBparams);
        $MysqlConnector = DatabaseFactory::save($MysqlFactory);
        $this->DBconector = $MysqlConnector;
    }
    public function consistency (): void 
    {

    }
    public function getPermission (): void 
    {
        Middleware::permissions($this->router, $this->APItoken, $this->DBconector);
    }
    public function Routing (): void 
    {
        $function = $this->router->uri[1] ?? 'getData';  // index
        GetController::$function(
            $this->DBconector,
            $this->router
        );
    }
}