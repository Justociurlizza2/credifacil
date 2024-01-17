<?php
namespace App\Factory\CuotaFactory;
use App\Factory\DatabaseFactory\DatabaseFactory;
use App\Factory\DatabaseFactory\MysqlDbFactory;
use Models\PostModel;
use Models\PutModel;
use Models\GetModel;
use Controllers\Helper;
use App\Tasa;

class Cuota {
    use Tasa;
    private int $cuotas;
    private float $monto;
    private float $tasa;
    private float $itasa;
    private float $cuota;
    private float $residuo = 0.00;
    private Array $data;
    private Object $DBconnector;
    public function __construct(private $router, public $APItoken)
    {
        $this->data = $router->data;
        $this->DBconnector = DatabaseFactory::save(new MysqlDbFactory());
    }
    public function create(): void
    {
        PostModel::postData($this->DBconnector, $this->router);
    }
    public function pagar(): void
    {
        $this->router->data = ['stat' => 5, 'codigo' => $this->data['codigo']];
        $params = helper::builderQueryParams((object)$this->router, 'codigo');
        PutModel::update($this->DBconnector, $params);
    }
    public function getCuota(): object
    {
        $this->router->table = 'cuotas';
        $params = helper::builderQueryParams((object)$this->router, 'codigo');
        return GetModel::getFilterData($this->DBconnector, $params)[0];
    }
    public function micuota(): http_response_code
    {
        $cuota = $this->calculate();
        helper::http((array)$cuota, 200);
    }
    public function calculate (): object
    {
        $this->initTasa($this->data['tasa'], $this->data['tipo'], $this->data['plazo']);
        $this->calcMonto();
        $this->calcCuotas();
        $this->calcCuota();
        $this->calcResiduo();
        return $this->buildCuota();
    }

    private function calcMonto (): void
    {
        Helper::avoidEmpty($this->data, ['plazo', 'tasa', 'inicio']);
        $this->monto = $this->data['credito'] * $this->tasaConPlazo;
        $this->monto = number_format($this->monto, 2, '.', '');
    }
    private function calcCuotas(): void
    {
        if($this->data['periodo'] > $this->data['plazo']) helper::http('Forma de pago excede el plazo');
        $this->cuotas = $this->data['plazo'] / $this->data['periodo'];
    }
    private function calcCuota(): void
    {
        $this->cuota = $this->monto / $this->cuotas;
        $this->cuota = number_format($this->cuota, 2, '.', '');
    }
    private function buildCuota(): object
    {
        return (object) [
            'cuota'  => $this->cuota,
            'cuotas' => $this->cuotas,
            'ultimaQ'=> $this->ultimaQ(),
            'residuo'=> $this->residuo,
            'monto'  => $this->monto,
            'idc'    => $this->data['idc'],
            'tasa'   => $this->data['tasa'],
            'tipo'   => $this->data['tipo'],
            'plazo'  => $this->data['plazo'],
            'inicio' => $this->data['inicio'],
            'credito'=> $this->data['credito'],
            'periodo'=> $this->data['periodo'],
            'confirm'=> $this->confirmMoney(),
        ];
    }
    private function calcResiduo(): float
    {
        $this->residuo = $this->monto - $this->cuotaXCuotas();
        return $this->residuo = number_format($this->residuo, 2, '.');
    }
    private function confirmMoney(): float
    {
        return $this->cuotaXCuotas() + $this->residuo;
    }
    private function cuotaXCuotas(): float
    {
        $cuotaX = $this->cuota * $this->cuotas;
        return Number_format($cuotaX, 2, '.', '');
    }
    private function ultimaQ(): float
    {
        $ultimaQ = $this->cuota + $this->residuo;
        return number_format($ultimaQ, 2, '.', '');
    }
}