<?php
namespace Router;
use Router\AdminRouter;
use Router\ShopRouter;

class Router {
    private array $route;
    private array $router;
    private string $access = '';
    public function __construct ()
    {
        $params = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
        $route  = str_replace('?'.$params, '', $_SERVER['REQUEST_URI']);    /* Limpiamos parámetros */
        $this->route = explode('/', $route);                                  /* Generamos uri [/] amigable */   
        $this->route[0]= '/';
        if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== "on") 
            header('Location: https://credifacil.wiedens.com');             /* Enrutamos a dirección Https */
        if(!empty($this->route[1]) && isset($_GET['fbclid']))
            header('Location: https://credifacil.wiedens.com');             /* Enrutamos a plataforma desde facebook */
    }
    public function routing (): void
    {
        $this->setRouter();
        $instance = match ($this->access) {
            'shop' => "Router\\ShopRouter",
            'admin' => "Router\\AdminRouter",
        };
        $routing = new $instance();
        $routing ->index($this->route);
    }
    public function setRouter (): void
    {
        $Admin = new AdminRouter();
        $Shop  = new ShopRouter();
        if($Shop->match($this->route[1]))  $this->access = "shop";
        if($Admin->match($this->route[1])) $this->access = "admin";
        if(empty($this->access)) {                                              /* Evaluamos a que entorno se accede */
            $this->access = "shop"; $this->route[1] = "404";
        }
    }
}