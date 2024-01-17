<?php
namespace Router\RouterRepository;
use Router\RouterRepository\RouterRepository;
use Router\RouterRepository\Bridge\GetBridge;

use Router\Models\Router;
use App\Middleware\Middleware;
use Controllers\GetController;
use Controllers\Helper;

class GetRouter implements RouterRepository
{
    private $DBconector;
    public function __construct(private Router $router, private $APItoken)
    {
    }
    
    public function setBridge(): void
    {
        $this->DBconector = GetBridge::getDBconnector($this->APItoken);
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