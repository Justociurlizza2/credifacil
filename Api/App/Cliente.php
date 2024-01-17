<?php
namespace App;
use App\Factory\DatabaseFactory\DatabaseFactory;
use App\Factory\DatabaseFactory\MysqlDbFactory;
use Models\GetModel;
use Models\PutModel;
use Controllers\Helper;

class Cliente {
    public object $info;
    public function __construct(private $router, private $APItoken)
    {
        $this->router->table = 'clientes';
        $this->DBconnector = DatabaseFactory::save(new MysqlDbFactory());
        if(isset($this->router->data['idc']))
            $this->find($this->router->data['idc']);
    }
    public function hasDebt(): bool
    {
        return $this->info->deuda > 20 ? : false;
    }
    public function find(int $id): object
    {
        $this->router->params = [ 'link' => 'id', 'equal' => $id ];
        $rs = GetModel::getFilterData($this->DBconnector, $this->router);
        if(empty($rs)) helper::http('Ups! cliente no encontrado');
        $this->info = $rs[0];
        return $this;
    }
    public function saldar(float $monto, bool $deuda = true): void
    {
        if($deuda) {
            $saldo = $this->info->deuda - $monto;
        } else {
            $saldo = $this->info->deuda + $monto;
        }
        $this->router->data = [ 'id' => $this->info->id, 'deuda' => $saldo ];
        $params = helper::builderQueryParams((object)$this->router, 'id');
        // helper::http((array)$params);
        PutModel::update($this->DBconnector, $this->router);
    }
}