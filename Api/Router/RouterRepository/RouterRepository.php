<?php

namespace Router\RouterRepository;
use Router\Models\Router;

interface RouterRepository
{
    public function consistency (): void;
    public function getPermission (): void;
    public function Routing (): void;
    // public function setResource (): void;
}