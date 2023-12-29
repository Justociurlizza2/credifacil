<?php
namespace App\Repository\Models;
use Controllers\Helper;

class Router {

    /**
    * @var string[] $uri - List of URI's of the server
    */
    public $uri = [];
    /* customs variables */
    public $data = [];
    public $table= [];
    public $method;
    /**
    * @var string $server_method - Method of the server
    */
    public $server_method;

    /**
    * @var callable $callback - Callback to run after URI match
    */
    private $callback;

    /**
     * @var boolean $matched - Toggle on route matched
     */
    private $matched = false;

    /**
     * @var array $params - List of dynamic URI parameters
     */
    public $params = [];
    /**
     * @var string $trim - Rejex to trim URL
     */
    private $trim = '/\^$';

    /**
     * __construct - Fetch infromation from server
     * @return object
     */
    function __construct(){
        $uri = trim($_SERVER['REQUEST_URI'], $this->trim);
        $params = parse_url($uri, PHP_URL_QUERY);
        $this->server_method = strtolower($_SERVER['REQUEST_METHOD']);
        $uri  = str_replace('?'.$params, '', $uri);     /* Limpiamos parámetros */
        parse_str($params, $this->params);              /* Convertirmos en Params Array*/
        $this->uri = explode('/', $uri);
        $this->data = json_decode(file_get_contents('php://input'), true);
        $this->table= $this->uri[0];
        $this->method = $_SERVER['REQUEST_METHOD'];
    }
    /**
     * get - Adds a URI for matching with GET method
     * 
     * @param string $uri
     * @param callable $callback
     * @return void
     */
    public function get($uri, $callback){
        $this->match('get', $uri, $callback);
    }
    /**
     * post - Adds a URI for matching with POST method
     * 
     * @param string $uri
     * @param callable $callback
     * @return void
     */
    public function post($uri, $callback){
        $this->match('post', $uri, $callback);
    }

    /**
     * put - Adds a URI for matching with PUT method
     * 
     * @param string $uri
     * @param callable $callback
     * @return void
     */
    public function put($uri, $callback){
        $this->match('put', $uri, $callback);
    }

    /**
     * patch - Adds a URI for matching with PATCH method
     * 
     * @param string $uri
     * @param callable $callback
     * @return void
     */
    public function patch($uri, $callback){
        $this->match('patch', $uri, $callback);
    }

    /**
     * delete - Adds a URI for matching with DELETE method
     * 
     * @param string $uri
     * @param callable $callback
     * @return void
     */
    public function delete($uri, $callback){
        $this->match('delete', $uri, $callback);
    }

    /**
     * add - Adds a URI for matching
     * 
     * @param string $method
     * @param string $uri
     * @param callable $callback
     * @return void
     */
    public function add($method, $uri, $callback){
        $this->match(strtolower($method), $uri, $callback);
    }

    /**
     * match - Match URIs with server
     * 
     * @param string $method
     * @param string $uri
     * @param callable $callback
     * @return void
     */
    private function match($method, $uri, $callback){
        if($this->matched){
            return;
        }

        if($uri == '/') {
            $uri = '/'.implode('/', $this->uri);    /* Forzamos toda request pertenezca a un GROUP Method */
        }

        $uri = trim($uri, $this->trim);
        $current_uri = explode('/', $uri);
        $uri_length = count($current_uri);

        if($method != $this->server_method){
            return;
        }

        if($uri_length != count($this->uri)){
            return;
        }

        $matched = true;

        for($i = 0; $i < $uri_length; $i++){
            if($current_uri[$i] == $this->uri[$i]){
                continue;
            }
            if(isset($current_uri[$i][0]) && $current_uri[$i][0] == ':'){
                $this->params[substr($current_uri[$i], 1)] = $this->uri[$i];
                continue;
            }
            $matched = false;
            break;
        }

        if($matched){
            $this->callback = $callback;
            $this->matched = true;
        }
   
    }

    /**
     * listen - Run the callback function of matched route
     * @return void
     */
    public function listen(){
        if(!$this->matched){
            //header("HTTP/1.1 404 Not Found");
            return;
            // Helper::HttpResponse(['rs' => 'No found']);
        }

        call_user_func($this->callback, $this->params, $this->uri);
    }

}