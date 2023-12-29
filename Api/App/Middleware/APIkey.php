<?php
namespace App\Middleware;
use App\Factory\DatabaseFactory\DatabaseFactory;
use App\Factory\DatabaseFactory\MysqlDbFactory;
use App\Middleware\Encryption;
use Models\GetModel;
use Controllers\Helper;

class APIkey {
    private object $ApiKeyToken;
    private object $validApikey;
    public function __construct (private string $apikey = '')
    {
        if(empty($this->apikey)) $this->setApiKey();
        $this->ApiKeyToken = $this->setApiKeyToken();
        $this->existsApiKey();
    }
    protected function setApiKeyToken () : object
    {
        $apikey = Encryption::decode($this->apikey, 'api.pe.key');
        $this->validApikey = json_decode($apikey);
        $this->validApikey ?? Helper::HttpResponse(['rs' => 'Invalid ApiKey format'], 403);
        return $this->bodyBuilder();
    }
    protected function bodyBuilder () : object
    {
        return (object) [
            'apikey' => $this->apikey,
            'cuenta' => $this->validApikey->cu,
            'ruc'    => $this->validApikey->ruc ?? '',
            'access' => isset($this->validApikey->ruc) ? 'emisores' : 'accounts',
            'dbname' => isset($this->validApikey->ruc) ?  'bret'.$this->validApikey->ruc : 'api.pe.bretsia'
        ];   
    }
    protected function setApiKey (): void
    {
        $requestHeaders = apache_request_headers();
        $requestHeaders['x-api-key'] ?? Helper::HttpResponse(['rs' => 'API Key is required'], 403);
        $this->apikey = $requestHeaders['x-api-key'];
    }
    public function getApiKeyToken (): object
    {
        return $this->ApiKeyToken;
    }
    public function buildApiKey (array $body): string
    {
        Helper::avoidEmpty($body, ['cu','ruc']);
        return Encryption::Encode(json_encode($body), 'api.pe.key');
    }
    public function decodeApiKey (string $apikey, string $key = 'api.pe.key'): object
    {
        $decode = Encryption::decode($apikey, $key);
        return json_decode($decode);
    }
    public function getApiKey(): string
    {
        return $this->apikey;
    }
    protected function existsApiKey (): void
    {
        $MysqlConnector = DatabaseFactory::save(new MysqlDbFactory());
        $params = helper::builderQueryParams($this->ApiKeyToken, 'apikey');
        $rs = GetModel::getFilterData($MysqlConnector, $params);
        if(empty($rs)) Helper::HttpResponse(['rs' => 'ApiKey ya no está registrado en '.$params->table], 403);
    }
}