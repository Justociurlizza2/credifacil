<?php
namespace Models;
use Models\Connection;
use Controllers\Helper;
use PDO;

class GetModel{
    static public function getData($conector, $router) 
    {
        $stmt = $conector->connect()->prepare("SELECT * FROM $router->table");
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_CLASS);
    }
    static public function getFilterData($conector, $router)
    {
        $link  = $router->params['link'];
        $equal = $router->params['equal'];
        $stmt = $conector->connect()->prepare("SELECT * FROM $router->table WHERE $link = :$link");
        $stmt -> bindParam(":".$link, $equal, PDO::PARAM_STR);
        try {
            if($stmt->execute()) { return $stmt -> fetchAll(PDO::FETCH_CLASS); }
        } catch (\PDOException $e) {
            Helper::HttpResponse(['rs' => $e->getMessage()], 402);
        }
    }
    static public function getLikeData($conector, $router)
    {
        $link  = $router->params['link'];
        $equal = $router->params['equal'];
        $stmt =  $conector->connect()->prepare("SELECT * FROM $router->table WHERE $link LIKE :$link");
        $stmt -> bindParam(":".$link, $equal, PDO::PARAM_STR);
        try {
            $stmt -> execute(array(':'.$link => "%$equal%"));
            return $stmt -> fetchAll(PDO::FETCH_CLASS);
        } catch (\PDOException $e) {
            Helper::HttpResponse(['rs' => $e->getMessage()], 403);
        }
    }
}
