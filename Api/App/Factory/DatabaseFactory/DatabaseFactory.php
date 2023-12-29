<?php
namespace App\Factory\DatabaseFactory;
use Controllers\Helper;

abstract class DatabaseFactory
{
    // A direct factory method that allows subclasses to return
    // any concrete connectors of the desired interface, since it is made abstract
    // We will create the interface a little later
    abstract public function getDataBase(): IDataBaseConnector;

    // And this method will be the same for all databases
    static public function save( $databaseFactory)
    {
        $database = $databaseFactory->getDataBase();
        return $database;
        // return $database->connect();
        // $database->save($data);
        // $database->disconnect();
    }
}