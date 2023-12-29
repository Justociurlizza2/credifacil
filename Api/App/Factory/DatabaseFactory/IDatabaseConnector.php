<?php
namespace App\Factory\DatabaseFactory;

interface IDataBaseConnector
{
    public function connect(): Object;
    public function disconnect();
    public function setSettings(array $data): void;
}