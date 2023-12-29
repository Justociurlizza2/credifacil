<?php
namespace App\Strategy\WriterStrategy;

interface WriterStrategy
{
    public function convert();
    public function produce();
    public function save(String $route): Array;
}