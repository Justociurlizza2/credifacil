<?php
namespace App;
use Models\GetModel;
use Controllers\Helper;

class Resource {
    static public function getResource($conector, $data) {
        $agents = [   
            'idc'   =>  (object)['table' => 'clientes', 'name' => 'cliente', 'link' => 'id'],
            'idu'   =>  (object)['table' => 'usuarios', 'name' => 'usuario', 'link' => 'id'],
            'idce'  =>  (object)['table' => 'creditos', 'name' => 'credito', 'link' => 'codigo'],
            'idcu'  =>  (object)['table' => 'cuotas',   'name' => 'cuota',   'link' => 'codigo'],
        ];
        foreach ($data as $i => $res) {
            $res = json_decode(json_encode($res), true);
            foreach (array_keys($agents) as $key) {
                if(in_array($key, array_keys($res))) {
                    $resource = $agents[$key];
                    $params = (Object) [
                        "table" => $resource->table,
                        "params"=> [ "link"  => $resource->link, "equal" => $res[$key] ]
                    ];
                    $rs = GetModel::getFilterData($conector, $params);
                    if(empty($rs)) continue;            /* No incorpora recurso si no se halló */
                    $name = trim($resource->name,'"');
                    $data[$i]-> $name = array();        /* El recurso inicializa vacío [] */
                    $data[$i]-> $name = Helper::deleteKeys($rs[0], ['password','token']);
                }
            }
        }
        return $data;
    }
}