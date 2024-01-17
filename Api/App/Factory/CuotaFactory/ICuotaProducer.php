<?php
namespace App\Factory\CuotaFactory;

interface ICuotaProducer
{
    public function create(): void;
    public function pagar(): void;
    public function micuota(): http_response_code;
    public function getCuota(): object;
}