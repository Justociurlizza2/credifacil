<?php
namespace App\Strategy\WriterStrategy;
use Controllers\Helper;

class JsonProducer
{
    public function __construct(protected $file, protected $params = [])
    {

    }

    public function formating(): string
    {
        $body = json_decode($this->file, true);
        return $this->printJsonContent($body);
    }
    private function printJsonContent ($body, $space = 1): string
    {
        $array_keys = array_keys($body);
        $ispace = $space;
        $print = "{\n";                                         /* Abrimos sin salto y espaciado } */
        $print.= str_repeat("\t", $ispace);
        for ($i=0; $i < count($array_keys); $i++) {
            $key = $array_keys[$i];
            try {
                if(str_contains($body[$key], '{') || str_contains($body[$key], '[')) {
                    $jsonValue = $this->printJsonContent(json_decode($body[$key], true), ($ispace+1));
                    $body[$key] = $jsonValue;                       /* seteamos el campo con un nuevo json del valor } */
                } else {
                    $body[$key] = json_encode($body[$key]);
                }
            } catch (\Throwable $th) {
                helper::http($th->getMessage());
            }

            $print.= '"'.$key.'": '.$body[$key].",\n";          /* imprimimos clave - valor (plano o json) } */
            if(($i+1) == count($array_keys)) $print = substr($print, 0, -2);    /* Quitamos coma y espaciado final */
            $print.= str_repeat("\t", $ispace);
        }
        $print.= "\n".str_repeat("\t", ($ispace-1))."}";        /* Cerramos con salto, espaciado (-1) y } */
        return $print;
    }
}