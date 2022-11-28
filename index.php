<?php

use DI\Container;
use function DI\autowire;
use function DI\create;
use PaymentAuthorize\App\Controllers\PaymentAuthorizeContoller;
use PaymentAuthorize\Domain\PaymentAuthorize\Repository\IPaymentAuthorizeRepository;
use PaymentAuthorize\Domain\PaymentAuthorize\Repository\PaymentAuthorizeRepository;
use PaymentAuthorize\Domain\PaymentAuthorize\UseCase\AuthorizePaymentUC;
use PaymentAuthorize\Domain\PaymentAuthorize\UseCase\IAuthorizePaymentUC;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

/** @var Container $this */

$container = new Container();
$container->set('PaymentAuthorizeContoller', autowire(PaymentAuthorizeContoller::class));
$container->set(IAuthorizePaymentUC::class, autowire(AuthorizePaymentUC::class));
$container->set(IPaymentAuthorizeRepository::class, create(PaymentAuthorizeRepository::class));

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
