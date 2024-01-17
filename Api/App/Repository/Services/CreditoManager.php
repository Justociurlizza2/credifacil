<?php
namespace App\Repository\Services;
use Router\Models\Router;
use App\Repository\CreditoRepository\CreditoRepository;
use App\Factory\CuotaFactory\CuotaFactory;

class CreditoManager {
    public static function create(CreditoRepository $creditoRepository): void
    {
        $creditoRepository->create();
    }
    public static function pagar(CreditoRepository $creditoRepository, CuotaFactory $cuota): void
    {
        $creditoRepository->pagar($cuota);
    }
}