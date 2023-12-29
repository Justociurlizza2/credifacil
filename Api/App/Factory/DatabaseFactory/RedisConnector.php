<?php
namespace App\Factory\DatabaseFactory;
use App\Factory\DatabaseFactory\IDatabaseConnector;

class RedisConnector implements IDataBaseConnector
{
    public function __construct(private $login, private $password)
    {}

    /**
     * @throws Exception
     */
    public function connect(): void
    {
        // connect() method implementation
    }

    public function disconnect()
    {
        // disconnect() method implementation
    }

    public function save(array $data): void
    {
        // save() method implementation
    }
}