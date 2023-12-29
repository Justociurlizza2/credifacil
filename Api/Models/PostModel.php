<?php
namespace Models;
use Models\Connection;
use Controllers\Helper;
use PDO;

class PostModel {
    static public function getColumnsData($conector, $router) {
        return $conector->connect()->query
        ("SELECT COLUMN_NAME AS item FROM information_schema.columns WHERE table_schema='$conector->dbname' AND table_name='$router->table'")
        ->fetchAll(PDO::FETCH_OBJ);
    }
    static public function postData ($conector, $router)
    {
        $columns = "("; $paramns = "(";
        foreach ($router->data as $key => $value) { $columns .= $key.","; $paramns .= ":".$key.","; }
        $columns = substr($columns, 0, -1).str_repeat(")", 1);
        $paramns = substr($paramns, 0, -1).str_repeat(")", 1);
        
        $stmt = $conector->connect()->prepare
        ("INSERT INTO $router->table $columns VALUES $paramns");
        foreach ($router->data as $key => $value) {
            $stmt->bindParam(":".$key, $router->data[$key]);
        }
        try {
            if($stmt->execute()) { return "The process was successful"; }
        } catch (\PDOException $e) {
            Helper::HttpResponse(['rs' => $e->getMessage().' code: '.$e->getcode() ], 401);
        }
    }
}