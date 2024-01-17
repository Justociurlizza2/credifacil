<?php
namespace App;
use App\Strategy\WriterStrategy\SystemWriter;
use App\Factory\CuotaFactory\CuotaFactory;
use App\Factory\CuotaFactory\Cuota;
use Controllers\Helper;

class Cronograma {
    private object $headCuota;
    public string $inicioPago;
    public string $findelPago;
    public float $monto;
    public function __construct (private int $codigoCredito)
    {
    }
    public function programar(CuotaFactory $cuotaFactory): object
    {
        $cuota = new Cuota($cuotaFactory->router, $cuotaFactory->APIkey);
        $this->headCuota  = $cuota->calculate();
        $this->monto      = $this->headCuota->monto;
        $this->inicioPago = $this->headCuota->inicio;
        $this->inicioPago = date('Y-m-d', strtotime($this->inicioPago));
        return $this->builder();
    }
    private function builder(): object
    {
        $cuotasList = [];
        $calendar = $this->getCalendar();
        foreach ($calendar as $it => $fecha) {
            $money = $this->headCuota->cuota;
            if($it + 1 == count($calendar))
                $this->findelPago = $fecha;
                $money = $this->headCuota->ultimaQ;
                
            $bodyCuota = $this->setupCuota($fecha, $money);
            $bodyCuota = json_encode($bodyCuota);
            $cuotasList[] = $bodyCuota;
        }
        $body = ["cronograma" => json_encode($cuotasList)];
        return (object) $body;
    }
    private function setupCuota(string $fecha, $money): object
    {
        $builder = clone $this->headCuota;  /* Clonamos para no alterar cuota cabecera */
        $builder-> inicio = $fecha;
        $builder-> cuota  = $money;
        $builder-> idce   = $this->codigoCredito;
        return $builder;
    }
    private function getCalendar(): array
    {
        $calendar = [];
        $init = date('Y-m-d', strtotime($this->inicioPago));
        for ($i=0; $i < $this->headCuota->cuotas; $i++) { 
            $init = date("Y-m-d", strtotime($init."+ ".$this->headCuota->periodo." days"));
            $calendar[] = $init;
        }
        return $calendar;
    }
}