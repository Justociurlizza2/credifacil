<?php
namespace Models;
use Models\Connection;
use Controllers\Helper;
use PDO;

class PutModel{
    static function update ($conector, $router)
    {
        $link = $router->params['link'];
        $equal = $router->params['equal'];
        $columns = "";

        foreach ($router->data as $key => $value) { $columns .= $key."=:".$key.","; }
        $columns = substr($columns, 0, -1);
        $stmt = $conector->connect()->prepare("UPDATE $router->table SET $columns WHERE $link = :$link");
        $stmt->bindParam(":".$link , $equal, PDO::PARAM_STR);
        // Helper::http($equal);
        foreach ($router->data as $key => $value) {
            $stmt->bindParam(":".$key, $router->data[$key], PDO::PARAM_STR);
        }

        try {
            if($stmt->execute()) return "The process was successful";
        } catch (\PDOException $e) {
            Helper::http($e->getMessage().' code: '.$e->getcode(), 401);
        }
    }
}