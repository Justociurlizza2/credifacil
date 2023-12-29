<?php
namespace App;
use Controllers\Helper;

trait Tasa
{
    private int $tipo;
    private int $plazo;
    public float $tasaConplazo;
    private float $itasa;
    private float $tasa;
    public function initTasa (float $tasa, int $tipo, int $plazo)
    {
        $this->tipo  = $tipo;
        $this->plazo = $plazo;
        $this->tasaConPlazo = 5;
        $this->setTasa();
        $this->setTasaDiaria();
        $this->tasaConPlazo();
    }
    protected function setTasa(): void
    {
        $tasa = ($this->data['tasa'] / 100);
        $this->tasa = number_format($tasa, 3, '.');
    }
    protected function setTasaDiaria(): void
    {
        $this->itasa = $this->tasa / $this->tipo;
    }
    private function tasaConPlazo(): void
    {
        $this->tasaConPlazo =  1 + ($this->itasa * $this->data['plazo']);
    }
}
