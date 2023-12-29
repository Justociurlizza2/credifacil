<?php
namespace App\Strategy\WriterStrategy;
use App\Strategy\WriterStrategy\WriterStrategy;
use Controllers\Helper;

class TxtWriter implements WriterStrategy
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
        // Helper::HttpResponse(['rs' => ''produce json], 400);
        return 'Txt';
    }

    public function save(String $route): void
    {
        $this->route = $route;
        // Helper::HttpResponse(['rs' => gettype($this->file)], 400);
        $fhandle = fopen($route, "w+");
        fputs($fhandle, $this->file);
        fclose($fhandle);
        Helper::HttpResponse(['rs' => 'Guardado exitosamente'], 200); exit;
    }
}