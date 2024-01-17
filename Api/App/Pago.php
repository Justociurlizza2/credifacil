<?php
namespace App;
use App\Factory\DatabaseFactory\DatabaseFactory;
use App\Factory\DatabaseFactory\MysqlDbFactory;
use Models\PostModel;
use Controllers\Helper;
use App\Factory\CuotaFactory\CuotaFactory;
use App\Repository\Services\CreditoManager;
use App\Repository\CreditoRepository\CreditoStandard;
use App\Cliente;

class Pago {
    private Array $data;
    private Object $DBconnector;
    public function __construct(public $router, public $APItoken)
    {
        $this->data = $router->data;
        $this->DBconnector = DatabaseFactory::save(new MysqlDbFactory());
    }
    function pagar(): void
    {
        $crediRouter = clone $this->router;
        $cuotaRouter = clone $this->router;
        $clientRouter= clone $this->router;
        $creditoStandard = new CreditoStandard($crediRouter, $this->APItoken);
        $cuota = CuotaFactory::init($cuotaRouter, $this->APItoken);
        $cliente = new Cliente($clientRouter, $this->APItoken);

        $info = $cuota->getCuota();
        $cliente = $cliente->find($info->idc);
        CreditoManager::pagar($creditoStandard, $cuota);
        $cliente->saldar($info->cuota);
        $cuota  -> pagar();

        helper::http('cuota pagada y crédito amortizado', 200);
    }
}