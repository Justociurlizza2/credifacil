<?php
namespace App\Factory\DatabaseFactory;
use Controllers\Helper;

enum Frame
{
    case API;
    case BRET;
    public function DBparams(string $dbname = ''): array
    {
        return match ($this) 
        {
            Frame::API  => [ 'handler' => 'mysql', 'host' => 'localhost', 'dbname' => 'credifacil'],
            Frame::BRET => [ 'handler' => 'mysql', 'host' => 'localhost', 'dbname' => $dbname ]
        };
    }
}
class MysqlDbFactory extends DatabaseFactory
{
    public function __construct(protected array $settings = [], private $frame = 'API')
    {
        $this->settings = match ($frame) {
            'API'  => Frame::API->DBparams(),
            'BRET' => Frame::BRET->DBparams($settings['dbname']),
        };
    }

    // Concrete Factory DB Method Implementation
    public function getDataBase(): IDataBaseConnector
    {
        return new MysqlConnector($this->settings);
    }
}