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

$router = new Router();
/* ------------------------------- No-Auth Endpoints ------------------------------- */
$router->get('', function() { Helper::http('Welcome to your Asistant CrediFacil', 202); });
$router->post('/micuenta/login',  function() use ($router) { PostController::login('accounts', $router); });
$router->post('/miusuario/login', function() use ($router) { PostController::login('usuarios', $router); });
$router->post('/accounts/create', function() use ($router) {
    $new = AccountFactory::init($router);
    $new->create();
});
$router->listen();
/* --------------------------------- Auth Endpoints -------------------------------- */
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
    RouterManager::routing($router, $deleteRouter);
});
$router->listen();