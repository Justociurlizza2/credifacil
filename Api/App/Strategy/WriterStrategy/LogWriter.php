<?php
namespace App\Strategy\WriterStrategy;
use App\Strategy\WriterStrategy\WriterStrategy;
use Controllers\Helper;

class LogWriter implements WriterStrategy
{
    private String $route;
    public function __construct(protected $file, protected $params)
    {

    }

    public function convert()
    {

    }

    public function produce()
    {
        $json = json_encode($this->file);
        return json_decode($json);
    }

    public function save(String $route): Array
    {
        $this->route = $route;
        // $this->route = Helper::routeTimestamp($this->route);
        $fhandle = fopen($this->route, "a");
        // $fhandle = fopen($this->route, "w+");
        fputs($fhandle, $this->file);
        fclose($fhandle);
        return array(200, $this->route);
    }
}