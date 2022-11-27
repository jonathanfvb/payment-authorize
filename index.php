<?php

use DI\Container;
use function DI\autowire;
use PaymentAuthorize\App\Controllers\PaymentAuthorizeContoller;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

/** @var Container $this */

$container = new Container();
$container->set('PaymentAuthorizeContoller', autowire(PaymentAuthorizeContoller::class));

AppFactory::setContainer($container);

$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

$app->get('/', function(RequestInterface $request, ResponseInterface $response, $args) {
    $response = $response->withHeader('Content-Type', 'application/json');
    $response->getBody()->write('{"message": "ok"}');
    return $response;
});

$app->post('/authorize/{payment_id}', function(RequestInterface $request, ResponseInterface $response, $args) {
    /** @var PaymentAuthorizeContoller $controller */
    $controller = $this->get('PaymentAuthorizeContoller');
    return $controller->authorize($request, $response);
});

$app->run();
