<?php

namespace Router\Services;
use Router\Models\Router;
use Router\RouterRepository\RouterRepository;

class RouterManager {
    public static function routing(Router $router, RouterRepository $RouterRepository): void
    {
        $RouterRepository->consistency();
        $RouterRepository->getPermission();
        $RouterRepository->routing();
    }
}