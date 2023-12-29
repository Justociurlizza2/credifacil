<?php
namespace App\Factory\AccountFactory;
use App\Factory\AccountFactory\IBusinessManager;

interface IBusinessEntity extends IBusinessManager
{
    public function create(): void;
    public function asociar(): void;
    public function suspend(): void;
    public function activate(): void;
    public function migrate(): void;
}