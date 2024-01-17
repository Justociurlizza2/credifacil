<?php
namespace App\Factory\CuotaFactory;
use App\Factory\CuotaFactory\CuotaFactory;
use App\Factory\CuotaFactory\StandardProducer;

class StandardFactory extends CuotaFactory
{
    private object $producer;
    public function __construct(public $router, public $APIkey)
    {
        $this->router->table = 'cuotas';
        $this->producer = new StandardProducer($router, $APIkey);
    }
    public function create(): void
    {
        $this->producer-> create();
    }
    public function pagar(): void
    {
        $this->producer-> pagar();
    }
    public function micuota(): http_response_code
    {
        $this->producer-> micuota();
    }
    public function getCuota(): object
    {
        return $this->producer->getCuota();
    }
}