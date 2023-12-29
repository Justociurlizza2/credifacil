<?php
namespace App\Factory\DatabaseFactory;
use App\Factory\DatabaseFactory\IDatabaseConnector;
use Controllers\Helper;
use PDO;

class MysqlConnector implements IDataBaseConnector
{
    public string $dbname;
    private $PDOException;
    public function __construct(private Array $settings)
    {
        $this->dbname = $settings['dbname'];
    }
    public function connect() : Object
    {
        date_default_timezone_set("America/Lima");
        try {
            $PDO = new PDO("mysql:
                                host=".$this->settings['host'].";
                                dbname=".$this->settings['dbname'],
                                "wiedens", 'Er41mp3ri@l:2023'
                            );
            $PDO -> exec("set names utf8");

        } catch(PDOException $e){
            $this->PDOException = $e;
            $this->disconnect();
        }
        return $PDO;
    }

    public function disconnect()
    {
        Helper::HttpResponse(['rs' => $e->getMessage()], 400);
        die();
    }

    public function setSettings (array $settings): void
    {
        $settings['host']   ??= $this->settings['host'];
        $settings['dbname'] ??= $this->settings['dbname'];
        $this->settings = $settings;
    }
    public function getSettings(): Array
    {
        return $this->settings;
    }
}