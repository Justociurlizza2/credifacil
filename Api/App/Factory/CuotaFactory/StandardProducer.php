<?php
namespace App\Factory\CuotaFactory;
use App\Factory\CuotaFactory\CuotaFactory;
use App\Factory\CuotaFactory\ICuotaProducer;
use App\Factory\CuotaFactory\Cuota;
use App\Cronograma;

class StandardProducer implements ICuotaProducer
{
    private Cuota $cuota;
    public function __construct(public $router, public $APIkey)
    {
        $this->cuota = new Cuota($this->router, $this->APIkey);
    }
    public function create(): void
    {
        $this->cuota -> create();
    }
    public function pagar(): void
    {
        $this->cuota -> pagar();
    }
    public function micuota(): http_response_code
    {
        $this->cuota -> micuota();
    }
    public function getCuota(): object
    {
        return $this->cuota->getCuota();
    }
}