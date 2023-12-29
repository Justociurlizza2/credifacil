<?php 
namespace Router;

class ShopRouter {
    public array $routes; 
    public function __construct ()
    {
        $this->routes = ['', 'register', 'login'];
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
        
        include_once('public/shop/header.php');
        if(empty($route[1])) { include_once "public/shop/main.php"; return; }
        include_once('public/shop/'.$route[1].'.php');
    }
}