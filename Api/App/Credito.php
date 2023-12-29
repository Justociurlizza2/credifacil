<?php
namespace App;
use App\Factory\DatabaseFactory\DatabaseFactory;
use App\Factory\DatabaseFactory\MysqlDbFactory;
use App\Strategy\WriterStrategy\SystemWriter;
use Models\PostModel;
use Controllers\Helper;
use App\Cronograma;
use App\Cuota;
use App\Tasa;

class Credito {
    private array $data;
    private Object $DBconnector;
    private Cronograma $cronograma;
    public function __construct(private $router, private Object $APItoken)
    {
        $MysqlFactory = new MysqlDbFactory();
        $this->DBconnector = DatabaseFactory::save($MysqlFactory);
        $this->data   = $this->router->data;
    }
    public function create(): void
    {
        /*............... Registramos cuotas y Programamos ...............*/
        $cuota    = new Cuota($this->router, $this->APItoken);
        $programa = $this->programar($cuota);
                    $this->createByCronograma($programa);
                    $json = json_encode($programa);
        $SystemWriter = new SystemWriter($json, 'Json');
        $SystemWriter -> convert();
        $SystemWriter -> save('public/ordenes/cuotasList2.json');
        /*...................Registramos nuevo crédito ...................*/
        $this->router->data           = $this->data;
        $this->router->data['codigo'] = $this->setupCode();
        $this->router->data['inicio'] = $this->cronograma->inicioPago;
        $this->router->data['fin']    = $this->cronograma->findelPago;
        $this->router->data['saldo']  = $this->router->data['credito'];
        $this->router->data['idu']    = $this->APItoken->APItoken->data->id;
        $this->router->table          = 'creditos';
        // helper::http((array) $this->router->data);
        PostModel::postData($this->DBconnector, $this->router);
        helper::http('Crédito registrado para su aprobación', 200);
    }
    private function programar(Cuota $cuota): object
    {
        $this->cronograma = new Cronograma();
        return $this->cronograma->programar($cuota);
    }
    private function createByCronograma($programa): void
    {
        $cuotas = json_decode($programa->cronograma);
        foreach ($cuotas as $cuota) {
            $this->router->table = 'cuotas';
            $this->router->data  = json_decode($cuota, true);
            PostModel::postData($this->DBconnector, $this->router);
        }
    }
    private function setupCode(): int
    {
        return rand(10, 99) * 10000 + rand(10, 999);
    }
}