<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/config.php';

$app = new \Slim\App;

//Rotas Pessoa.php
require '../src/routes/routes.php';

$app->run();