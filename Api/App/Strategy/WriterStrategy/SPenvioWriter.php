<?php
namespace App\Strategy\WriterStrategy;
use App\Strategy\WriterStrategy\WriterStrategy;
use Controllers\Helper;

class SPenvioWriter implements WriterStrategy
{
    private String $route;
    public function __construct(protected $file, protected $params)
    {
    }

    public function convert()
    {
        // $body = (Array) $this->params;
        $body = json_decode($this->params, true);
        $print = $this->printJsonContent($body, 1);
        $this->file = $print;
    }

    public function produce()
    {
        $data = $this->params;
        $resp = json_decode($this->file)->respuesta;
        /* ---------------- data del Request ---------------- */
        $data['idServicio'] = $data['paquete']['idServicio'];
        $data['tipo_paquete']=$data['paquete']['tipo_paquete'];
        $data['fecha']      = date('Y-m-d H:i:s');
        $data['destino']    = json_encode($data['destino']);
        $data['paquete']    = json_encode($data['paquete']);
        /* ---------------- data API response ---------------- */
        $data['precio']     = str_replace(',', '', $resp->pedido->total);
        $data['origen']     = json_encode($resp->peticion->origen);
        $data['pedido']     = json_encode($resp->pedido);
        $data['numero_guia']= $resp->pedido->numero_guia;
        $data['idPedido']   = $resp->pedido->idPedido;
        $data['etiqueta']   = $resp->etiqueta;
        $data['referencia'] = strtoupper(substr($resp->peticion->origen->ciudad, 0, 3)).'-'.
                              strtoupper(substr($resp->peticion->destino->ciudad, 0, 3)).'.'.date('dmy');
        $this->params = $data;        /* Ahora el contenido (file) es el body */
        $this->convert();
    }

    public function save(String $route): Array
    {
        $this->route = $route;
        $this->route = Helper::routeTimestamp($this->route, '.json');
        $fhandle = fopen($this->route, "w+");
        fputs($fhandle, $this->file);
        fclose($fhandle);
        return array(200, $this->route);
    }
    private function printJsonContent ($body, $space): String
    {
        $array_keys = array_keys($body);
        $ispace = $space;
        $print = "{\n";                                         /* Abrimos sin salto y espaciado } */
        $print.= str_repeat("\t", $ispace);
        for ($i=0; $i < count($array_keys); $i++) {
            $key = $array_keys[$i];
            if(str_contains($body[$key], '{')) {
                $jsonValue = $this->printJsonContent(json_decode($body[$key], true), ($ispace+1));
                $body[$key] = $jsonValue;                       /* seteamos el campo con un nuevo json del valor } */
            } else {
                $body[$key] = json_encode($body[$key]);
            }
            $print.= '"'.$key.'": '.$body[$key].",\n";          /* imprimimos clave - valor (plano o json) } */
            if(($i+1) == count($array_keys)) $print = substr($print, 0, -2);    /* Quitamos coma y espaciado final */
            $print.= str_repeat("\t", $ispace);
        }
        $print.= "\n".str_repeat("\t", ($ispace-1))."}";        /* Cerramos con salto, espaciado (-1) y } */
        return $print;
    }
}