<?php
namespace App;
use Firebase\JWT\JWT;
use Models\GetModel;
use App\Middleware\Encryption;
use App\Middleware\APIkey;
use App\Factory\DatabaseFactory\DatabaseFactory;
use App\Factory\DatabaseFactory\MysqlDbFactory;
use Controllers\Helper;

class Auth {
    private Object $APItoken;
    private String $token = '';
    private Object $ApiKey;
    private String $DBname;
    public  Array $DBparams;
    public function __construct ()
    {
        $this->getBearerToken();
        // $this->getApiKeyToken();
        $this->validateToken();
    }
    public function __invoke (): Object
    {
        return (Object) [
            'APItoken'  => $this->APItoken,
            // 'APIkey'    => $this->ApiKey,
            'DBparams'  => $this->DBparams
        ];
    }
    /* Get hearder Authorization */
    private function getAuthorizationHeader (): string {
        $headers = 'none';
        if       (isset($_SERVER['Authorization'])) $headers = trim($_SERVER["Authorization"]);
        else if  (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) $headers = trim($requestHeaders['Authorization']);
        }
        return $headers;
    }
    /* get access token from header */
    private function getBearerToken() {
        $headers = $this->getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers) && preg_match('/Bearer\s(\S+)/', $headers, $matches)) 
            return $this->token = $matches[1];
            helper::http('Token de seguridad requerido', 405);
    }

    private function validateToken (): void {
        $this->APItoken = $this->is_validToken();
        $this->APItoken->data->token = $this->token;
        $MysqlFactory = new MysqlDbFactory();
        $MysqlConnector = DatabaseFactory::save($MysqlFactory);
        $this->DBparams = $MysqlConnector->getSettings();   /* Capturamos DBparams del Frame */
        $params = helper::builderQueryParams($this->APItoken->data, 'token');
        $person = GetModel::getFilterData($MysqlConnector, $params);
        // var_dump($person); exit;
        // helper::http($params);
        // helper::http($person->result, 201);
        if(empty($person)) Helper::http('Token No autorizado en '. $this->APItoken->data->access, 403);
        if(time() >= $this->APItoken->exp) Helper::http('Token expirado', 405);
    }
    private function is_validToken () {
        try {
            JWT::$leeway = 60;      // $leeway in seconds
            return JWT::decode($this->token, 'kejwak4e5r2fet4xyzdmfl49e308', array('HS256'));
        } catch (\Exception $e) {
            Helper::HttpResponse(['rs' => 'Error: '. $e->getMessage()], 405);
        }
    }

    private function getApiKeyToken () : void
    {
        $APIkey = new APIkey();
        $this->ApiKey = $APIkey->getApiKeyToken();
    }
}