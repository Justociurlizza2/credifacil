<?php
namespace App\Strategy\WriterStrategy;
use App\Strategy\WriterStrategy\WriterStrategy;
use App\Strategy\WriterStrategy\JsonProducer;
use Controllers\Helper;

class JsonWriter implements WriterStrategy
{
    private String $route;
    public function __construct(protected $file, protected $params)
    {

    }

    public function convert(): void
    {
        $jsonFormat = new JsonProducer($this->file);
        $this->file = $jsonFormat->formating();
    }

    public function produce()
    {
        $json = json_encode($this->file);
        return json_decode($json);
    }

    public function save(String $route): Array
    {
        $this->route = $route;
        $fhandle = fopen($route, "w+");
        fputs($fhandle, $this->file);
        fclose($fhandle);
        return array(200, $this->route);
    }
}