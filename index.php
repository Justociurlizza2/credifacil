<?php 
require('vendor/autoload.php');
require 'vendor/vlucas/phpdotenv/src/Dotenv.php';
require 'vendor/vlucas/phpdotenv/src/Loader/Loader.php';
require 'vendor/vlucas/phpdotenv/src/Validator.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
ob_start();

use Router\Router;
$router = new Router();
$router-> routing();