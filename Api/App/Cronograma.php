<?php
namespace App;
use App\Strategy\WriterStrategy\SystemWriter;
use Controllers\Helper;
use App\Cuota;

class Cronograma {
    private object $headCuota;
    public string $inicioPago;
    public string $findelPago;
    public function __construct ()
    {
    }
    public function programar(Cuota $cuota): object
    {
        $this->headCuota  = $cuota->calculate();
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