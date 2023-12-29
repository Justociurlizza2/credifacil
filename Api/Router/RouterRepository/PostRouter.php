<?php
namespace Router\RouterRepository;
use Router\RouterRepository\RouterRepository;
use App\Factory\DatabaseFactory\DatabaseFactory;
use App\Factory\DatabaseFactory\MysqlDbFactory;
use Router\Models\Router;
use App\Middleware\Middleware;
use Controllers\PostController;
use Controllers\Helper;
use App\Factory\AccountFactory\AccountFactory;
use App\Cuota;

class PostRouter implements RouterRepository
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
        $cols = array_map(fn($c) => $c->item, $dbtable); array_shift($cols);
        // helper::http($this->router, 402);
        foreach (array_keys($this->router->data) as $k => $camp) Helper::notBelong($cols, $camp, 'Propiedades no coinciden');
    }
    public function getPermission (): void 
    {
        Middleware::permissions($this->router, $this->APItoken, $this->DBconector);
    }
    public function Routing (): void 
    {
        $function = $this->router->uri[1] ?? 'create';
        if(in_array($this->router->uri[0], ['cuotas', 'creditos'])) {
            $instance = match ($this->router->uri[0]) {
                'cuotas'   => 'App\\Cuota',
                'creditos' => 'App\\Credito'
            };
            // helper::http($instance);
            $business = new $instance($this->router, $this->APItoken);
            $business -> $function();
        }
        
        PostController::$function(
            $this->DBconector,
            $this->router
        );
    }
}