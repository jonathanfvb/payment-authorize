<?php

use Slim\Factory\AppFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

$app->get('/', function(RequestInterface $request, ResponseInterface $response, $args) {
    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write('{"message": "ok"}');
    return $response;
});

$app->run();