<?php
namespace App\Repository\Models;
use App\Factory\DatabaseFactory\DatabaseFactory;
use App\Factory\DatabaseFactory\MysqlDbFactory;
use App\Strategy\WriterStrategy\SystemWriter;
use Models\PostModel;
use Models\PutModel;
use Models\GetModel;
use Controllers\Helper;
use App\Factory\CuotaFactory\CuotaFactory;
use App\Cronograma;

class Credito {
    private array $data;
    private Object $DBconnector;
    private CuotaFactory $cuota;
    private Cronograma $cronograma;
    public function __construct(private $router, private Object $APItoken)
    {
        $this->data = $this->router->data;
        $this->DBconnector = DatabaseFactory::save(new MysqlDbFactory());
    }
    public function create(): void
    {
        /*............... Registramos cuotas y Programamos ...............*/
        $codigo   = $this->setupCode();
        $this->cuota = CuotaFactory::init($this->router, $this->APItoken);
        $programa = $this->programar($codigo);
                    $this->createByCronograma($programa);
                    $json = json_encode($programa);
        $SystemWriter = new SystemWriter($json, 'Json');
        $SystemWriter -> convert();
        $SystemWriter -> save('public/ordenes/cuotasList2.json');
        /*...................Registramos nuevo crédito ...................*/
        $this->router->data           = $this->data;
        $this->router->table          = 'creditos';
        $this->router->data['codigo'] = $codigo;
        $this->router->data['inicio'] = $this->cronograma->inicioPago;
        $this->router->data['fin']    = $this->cronograma->findelPago;
        $this->router->data['saldo']  = $this->cronograma->monto;
        $this->router->data['idu']    = $this->APItoken->APItoken->data->id;

        PostModel::postData($this->DBconnector, $this->router);
    }

    public function pagar(CuotaFactory $cuota): void
    {
        $this->cuota = $cuota;
        $this->router->data = [
            'estado' => 2,
            'codigo' => $this->data['idce'],
        ];
        $this->router->data['saldo'] = $this->saldo();
        $params = helper::builderQueryParams((object)$this->router, 'codigo');
        PutModel::update($this->DBconnector, $params);
    }
    private function saldo()
    {
        $params = helper::builderQueryParams((object)$this->router, 'codigo');
        $credito= GetModel::getFilterData($this->DBconnector, $params);
        $saldoA = $credito[0]->saldo;
        $cuota  = $this->cuota->getCuota();
        return $saldoA - $cuota->cuota;
    }

    private function programar($codigo): object
    {
        $this->cronograma = new Cronograma($codigo);
        return $this->cronograma->programar($this->cuota);
    }
    private function createByCronograma($programa): void
    {
        $cuotas = json_decode($programa->cronograma);
        foreach ($cuotas as $cuota) {
            $this->cuota->router->data = json_decode($cuota, true);
            $this->cuota->create();
        }
    }
    private function setupCode(): int
    {
        return rand(10, 99) * 10000 + rand(10, 999);
    }
}