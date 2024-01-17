<?php
namespace App\Factory\CuotaFactory;
use App\Factory\CuotaFactory\StandardFactory;
use Controllers\Helper;

abstract class CuotaFactory
{
    static public function init($router, $APIkey): CuotaFactory
    {
        return new StandardFactory($router, $APIkey);
    }
    abstract public function create(): void;
    abstract public function pagar(): void;
    abstract public function micuota(): http_response_code;
}