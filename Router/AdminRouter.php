<?php 
namespace Router;
use Router\AdminTemplate;
class AdminRouter {
    public array $routes; 
    public function __construct ()
    {
        $this->routes = ['main', 'usuarios', 'creditos', 'cuotas'];
    }
    public function match (string $route): bool
    {
        return in_array($route, $this->routes);
    }
    public function index (array $route) {
        $ttl = (60 * 60 * 4);                       // session_set_cookie_params($ttl);
        ini_set("session.cookie_lifetime",$ttl);    //seteo el maximo tiempo de vida de la seession
        ini_set("session.gc_maxlifetime",$ttl);
        session_start();
        $adminTemplate = new AdminTemplate();
        $adminTemplate->render($route[1]);
    }
}