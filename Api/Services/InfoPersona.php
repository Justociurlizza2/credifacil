<?php
namespace Services;
use Controllers\Helper;

class InFopersona {
    static public function consultarDNI ($dni) {
        $token = 'apis-token-1.aTSI1U7KEuT-6bbbCguH-4Y8TI6KS73N';
        $curl = curl_init();
        // Buscar dni
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.apis.net.pe/v1/dni?numero=' . $dni,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 2,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
            'Referer: https://apis.net.pe/consulta-dni-api',
            'Authorization: Bearer ' . $token
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $persona = json_decode($response);
        if(!isset($persona->nombres)) { $res = array( 'status' => 401, 'result' => 'Person not found'); }
        else $res = array(
            'nombre' => $persona->nombres,
            'apellidos'=> $persona->apellidoPaterno.' '.$persona->apellidoMaterno
        );
        echo json_encode($res); return;
    }
    static public function consultarRUC ($ruc) {
        $ws = "https://api.apis.net.pe/v1/ruc?numero=".$ruc;
        $token = 'apis-token-1.aTSI1U7KEuT-6bbbCguH-4Y8TI6KS73N';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $ws,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
              'Referer: https://apis.net.pe/api-ruc',
              'Authorization: Bearer ' . $token
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $empresa = json_decode($response);
        $res = array( 'status' => 401, 'rs' => 
        'Contribuyente no está registrado en SUNAT, Si cree que es un error, favor contáctese al +51 916019978');
        if(isset($empresa->nombre)) {
            $empresa->razon_social     = $empresa->nombre;
            $empresa->nombre_comercial = $empresa->nombre;
            $empresa->tipodoc          = $empresa->tipoDocumento;
            $empresa->ruc              = $ruc;
            $res = array( 'status' => 200, 'rs' => $empresa);
        }
        return $res;
    }
}