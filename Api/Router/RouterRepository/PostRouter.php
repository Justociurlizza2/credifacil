<?php
namespace Router\RouterRepository;
use Router\RouterRepository\Bridge\PostBridge;
use Router\RouterRepository\RouterRepository;
use Router\Models\Router;
use App\Middleware\Middleware;
use Controllers\PostController;
use Controllers\Helper;

class PostRouter implements RouterRepository
{
    private string $instance = '';
    private object $DBconector;
    public function __construct(private Router $router, private Object $APItoken)
    {
    }

    public function setBridge(): void
    {
        $this->instance   = PostBridge::getInstance($this->router);
        $this->DBconector = PostBridge::getDBconnector($this->APItoken);
    }
    public function consistency (): void 
    {
        $dbtable = PostController::getColumnsData($this->DBconector, $this->router);
        $cols = array_map(fn($c) => $c->item, $dbtable); array_shift($cols);
        foreach (array_keys($this->router->data) as $k => $camp)
            Helper::notBelong($cols, $camp, 'Propiedades no coinciden');
    }
    public function getPermission (): void
    {
        Middleware::permissions($this->router, $this->APItoken, $this->DBconector);
    }
    public function Routing (): void 
    {
        $function = $this->router->uri[1] ?? 'create';
        if( str_contains($this->instance, 'Repository'))
        {
            // var_dump($this->router); exit;
            $repo = $this->instance.'CreditoRepository\CreditoStandard';
            $busi = $this->instance.'Services\CreditoManager';
            $repository = new $repo($this->router, $this->APItoken);
            $manager    = $busi::$function($repository);
        }
        if( str_contains($this->instance, 'Factory'))
        {
            $factory = $this->instance::init($this->router, $this->APItoken);
            $factory->$function();
        }
        $business = new $this->instance($this->router, $this->APItoken);
        $business -> $function();
    }
}