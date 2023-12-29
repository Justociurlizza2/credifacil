<?php

namespace Controllers;
class ViewController {

    static public function routing () {
        $route  = array();
        $params = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
        $route  = str_replace('?'.$params, '', $_SERVER['REQUEST_URI']); /* Limpiamos parámetros */
        $route  = explode('/', $route);                                  /* Generamos uri [/] amigable */   
        $route[0]= '/';
        if(empty($_SERVER['HTTPS']) || ("on" !== $_SERVER['HTTPS'])) 
            header('Location: https://www.bretsia.com');                /* Enrutamos a dirección Https */
        if(!empty($route[1]) && isset($_GET['fbclid']))
            header('Location: https://www.bretsia.com');                /* Enrutamos a plataforma desde facebook */

        $shop  = ['/', 'register', 'login', '404'];
        $admin = ['main'];
        $access = 'shop';                                               /* Evaluamos a que entorno se accede */
        if(!empty($route[1]) && in_array($route[1], $admin)) $access = 'admin';
        if(!empty($route[1]) && !in_array($route[1], $shop)) $route[1] = '404';

        return array (
            'path' => $route,
            'env'  => $access
        );
    }
}