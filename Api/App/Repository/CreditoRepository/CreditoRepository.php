<?php

namespace App\Repository\CreditoRepository;
use App\Repository\CreditoRepository\Models\Credito;
use App\Factory\CuotaFactory\CuotaFactory;

interface CreditoRepository
{
    public function create (): void;
    public function pagar (CuotaFactory $cuota): void;
}