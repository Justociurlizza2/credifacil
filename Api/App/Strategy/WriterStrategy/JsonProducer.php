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
    private function printJsonContent ($body, $space = 1, $clousure = "{"): string
    {
        $array_keys = array_keys($body);
        $ispace = $space;
        $print = $this->clousures($space, $clousure, 0);
        for ($i=0; $i < count($array_keys); $i++) {
            $key = $array_keys[$i];
            try {
                if(str_contains($body[$key], '[')) {
                    $jsonValue = $this->printJsonContent(json_decode($body[$key], true), ($ispace+1), "[");
                    $body[$key] = $jsonValue;                       /* El campo ahora es un nuevo Json embebido } */
                }
                else if(str_contains($body[$key], '{')) {
                    $jsonValue = $this->printJsonContent(json_decode($body[$key], true), ($ispace+1));
                    $body[$key] = $jsonValue;                       /* El campo ahora es un nuevo Json embebido } */
                } else {
                    $body[$key] = json_encode($body[$key]);
                }
            } catch (\Throwable $th) {helper::http($th->getMessage()); }

            $print.= $this->printKeyValue($key, $body[$key], $array_keys);
            if(($i+1) == count($array_keys)) $print = substr($print, 0, -2);    /* Quitamos coma y espaciado final */
            $print.= str_repeat("\t", $ispace);
        }
        $print.= $this->clousures($space, $clousure, 1);
        return $print;
    }
    private function clousures($space = 1, $char = "{", $startOrEnd = 0): string
    {
        $print = '';
        if($startOrEnd == 0) {
            $print = $char."\n";                                 /* Abrimos sin salto y espaciado } */
            $print.= str_repeat("\t", $space);
        } else{
            $char  = ($char == '{') ? '}' : ']';
            $print = "\n".str_repeat("\t", ($space-1)).$char;   /* Cerramos con salto, espaciado (-1) y } */
        }
        return $print;
    }
    private function printKeyValue($key, $value, $matriz): string
    {
        $char_key = '"'.$key.'": ';
        if(is_numeric($key)) $char_key = '';                    /* Consultamos si son índices numéricos*/
        return $char_key . $value.",\n";                        /* imprimimos clave - valor (plano o json) } */
    }
}