<?php
namespace Controllers;

Class RouteController {
    public function index(){
        include "BusinessObjects/Route.php";
    }
    public function db(){ return 'facturacion16';}
}