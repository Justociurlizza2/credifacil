<?php
namespace Router;
use App\Auth;
use Controllers\PostController;
use Controllers\Helper;
/*************** Factory & Repository ***************/
use Router\RouterRepository\PostRouter;
use Router\RouterRepository\GetRouter;
use Router\RouterRepository\PutRouter;
use Router\Services\RouterManager;
use Router\Models\Router;
use App\Factory\AccountFactory\AccountFactory;
use App\Strategy\WriterStrategy\SystemWriter;

// if($_SERVER['REMOTE_ADDR'] !== '38.250.131.144' || !isset($_SERVER['REMOTE_ADDR'])) {
//     $SystemWriter = new SystemWriter($_SERVER['REMOTE_ADDR']."\n", 'Log');
//     $SystemWriter ->save('App/Middleware/logs/blacklist.log');
//     Helper::http('Denegamos su acción, intente mañana', 405);
// }
$router = new Router();
/* ------------------------------- No-Auth Endpoints ------------------------------- */
// var_dump($router); exit;
$router->get('', function() { Helper::http('Welcome to your Asistant CrediFacil', 202); });
$router->post('/micuenta/login', function() use ($router) { PostController::postLogin('accounts', $router); });
$router->post('/miusuario/login', function() use ($router) { PostController::postLogin('usuarios', $router); });
$router->post('/accounts/create', function() use($router) {
    $new = AccountFactory::init($router);
    $new->create();
});
$router->listen();
/* ------------------------------ With Auth Endpoints ------------------------------ */
$APItoken = new Auth();
$router->get('/', function() use ($router, $APItoken) {
    $getRouter = new GetRouter($router, $APItoken());
    RouterManager::routing($router, $getRouter);
});
$router->post('/', function() use ($router, $APItoken) {
    $postRouter = new PostRouter($router, $APItoken());
    RouterManager::routing($router, $postRouter);
});
$router->put('/', function() use ($router, $APItoken) {
    $putRouter = new PutRouter($router, $APItoken());
    RouterManager::routing($router, $putRouter);
});
$router->delete('/', function() use ($router, $APItoken) {
    $deleteRouter = new PutRouter($router, $APItoken());
    RouterManager::routing($router, $putRouter);
});
$router->listen();











/* Microservicios */
// use GuzzleHttp\Psr7\Message;
// use Controllers\Usuario;
// use GuzzleHttp\Psr7\Response;

// Helper::HttpResponse(['rs' => 'go!']);
// $response = new Response(201, [], json_encode(['hi' => 'new']), '1.0');
// $string   = Message::toString($response);
// $message  = Message::parseMessage($string);
// $message['body'] = (object)json_decode($message['body']);
// echo json_encode($message);