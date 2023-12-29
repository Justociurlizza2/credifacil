<?php
namespace App\Factory\DatabaseFactory;

class RedisDbFactory extends DatabaseFactory
{
    // php8 allows you to add private login and password fields using the constructor
    public function __construct(private readonly string $login, private readonly string $password)
    {}

    // Concrete Factory Method Implementation
    // Returns an instance of the connector class that implements the DataBaseConnector interface
    public function getDataBase(): IDataBaseConnector
    {
        return new RedisConnector($this->login, $this->password);
    }
}