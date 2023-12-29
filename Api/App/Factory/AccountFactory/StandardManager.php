<?php
namespace App\Factory\AccountFactory;
use App\Factory\AccountFactory\IBusinessManager;
use App\Factory\AccountFactory\Cuenta;
use App\Factory\AccountFactory\Emisor;
use App\Middleware\Encryption;
use Controllers\PostController;
use Controllers\Helper;

use App\Factory\DatabaseFactory\DatabaseFactory;
use App\Factory\DatabaseFactory\MysqlDbFactory;

enum Limits: int
{
    case cuentas = 1;
    case emisores = 2;
    public function noExceed(int $num = 0): bool
    {
        return match ($this) 
        {
            Limits::cuentas  => $num >= 1 ? false : true,
            Limits::emisores => $num >= 2 ? false : true
        };
    }
}
class StandardManager implements IBusinessManager
{
    private IBusinessEntity $businessEntity;
    public function __construct(public $router, public $APIkey)
    {
        $instance = match ($router->table) {
            'accounts' => "App\\Factory\\AccountFactory\\". self::CUENTA,
            'emisores' => "App\\Factory\\AccountFactory\\". self::EMISOR
        };
        $this->businessEntity = new $instance($router, $APIkey);
    }
    public function create (): void
    {
        $this->businessEntity->create();
    }
    public function suspend (): void
    {
        $this->businessEntity->suspend();
    }
    public function activate (): void
    {
        $this->businessEntity->activate();
    }
    public function asociar (): void
    {
        $entities = $this->router->entity->emisores ?? $this->router->entity->cuentas;
        $quantity = count(json_decode($entities));  /* Obtenemos el número de entidades (cuentas o emisores) */
        $limit = match ($this->router->table) {
            'accounts' => Limits::emisores,
            'emisores' => Limits::cuentas
        };
        $limit->noExceed($quantity) ?
            $this->businessEntity->asociar() :
            Helper::http('Su plan Standard alcanzó su límite de '. $limit->value.' '. $limit->name);
    }
    protected function migrate (): void
    {
        $this->businessEntity->migrate();
    }
}