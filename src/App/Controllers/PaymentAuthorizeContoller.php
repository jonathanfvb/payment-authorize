<?php

namespace PaymentAuthorize\App\Controllers;

use PaymentAuthorize\Domain\PaymentAuthorize\DTO\AuthorizePaymentRequest;
use PaymentAuthorize\Domain\PaymentAuthorize\UseCase\IAuthorizePaymentUC;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Exception;

class PaymentAuthorizeContoller
{
    private IAuthorizePaymentUC $authorizedPayment;
    
    public function __construct(IAuthorizePaymentUC $authorizedPayment)
    {
        $this->authorizedPayment = $authorizedPayment;
    }
    
    public function authorize(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $paymentId = $request->getAttribute('payment_id');
        if (empty(trim($paymentId))) {
            throw new Exception("Parameter 'payment_id' is invalid");
        }
        
        $result = $this->authorizedPayment->execute(new AuthorizePaymentRequest($paymentId));
        
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode($result->toArray()));
        return $response;
    }
}
