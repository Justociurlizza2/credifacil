<?php
namespace App\Exception;

interface IBretsiaException extends \Throwable
{
    public function errorMessage(): void;
    public function matchErrorException(): void;
}