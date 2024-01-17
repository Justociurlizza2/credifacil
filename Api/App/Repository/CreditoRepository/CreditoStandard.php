<?php
namespace App\Repository\CreditoRepository;
use App\Repository\CreditoRepository\CreditoRepository;
use App\Repository\Models\Credito;
use App\Factory\CuotaFactory\CuotaFactory;
use Router\Models\Router;
use Controllers\Helper;
use App\Cliente;

class CreditoStandard implements CreditoRepository
{
    public function __construct(private Router $router, private Object $APItoken)
    {
        $this->router->table = 'creditos';
    }
    public function create(): void
    {
        $clientRouter = clone $this->router;
        $client = new Cliente($clientRouter, $this->APItoken);
        $client = $client->find($clientRouter->data['idc']);
        if($client->hasDebt()) helper::http('Lo sentimos, el cliente adeuda: s/ '. $client->info->deuda);

        $credito = new Credito($this->router, $this->APItoken);
        $credito -> create();
        $client  -> saldar($this->router->data['saldo'], false);
        helper::http('Crédito registrado para su aprobación', 200);
    }
    public function pagar(CuotaFactory $cuota): void
    {
        $credito = new Credito($this->router, $this->APItoken);
        $credito -> pagar($cuota);
    }
}