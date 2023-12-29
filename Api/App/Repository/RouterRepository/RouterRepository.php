<?php

namespace App\Repository\RouterRepository;
use App\Repository\Models\Router;

interface RouterRepository
{
    public function consistency (): void;
    public function getPermission (): void;
    public function Routing (): void;
    // public function setResource (): void;
}