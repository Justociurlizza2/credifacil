<?php

namespace App\Repository\Services;
use App\Repository\Models\Router;
use App\Repository\RouterRepository\RouterRepository;

class RouterManager {
    public static function routing(Router $router, RouterRepository $RouterRepository): void
    {
        $RouterRepository->consistency();
        $RouterRepository->getPermission();
        $RouterRepository->routing();
    }
}