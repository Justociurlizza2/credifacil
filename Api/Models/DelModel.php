<?php
require_once "connection.php";
class DelModel{
    public function delData($table, $item, $id){
        $stmt = Connection::connect()->prepare("DELETE FROM $table WHERE $item = :$item");
        $stmt->bindParam(":".$item, $id, PDO::PARAM_INT);
        if($stmt->execute()){ return "The process was successful"; }
        else {
            echo Connection::connect()->errorInfo();
        }
    }
}