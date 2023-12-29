<?php
namespace Models;
use Controllers\Helper;
use PDO;

class Connection{
    public String $handler;
    public String $host;
    public String $database;
    public function __construct($con) {
        $this -> handler  = $con['handler'];
        $this -> host     = $con['host'];
        $this -> database = $con['dbname'];
    }
    public function connect () {
        date_default_timezone_set("America/Lima");
        try{
            switch ($this->handler) {
                case 'mysql':
                    $link = new PDO("mysql:host=".$this->host.";dbname=".$this->database,"wiedens", 'Er41mp3ri@l:2023');
                    $link -> exec("set names utf8");
                    break;
                default:
                    die("Error: ".$e->getMessage());
                    break;
            }
        }catch(PDOException $e){
            die("Error: ".$e->getMessage());
        }
        return $link;
    }
}
