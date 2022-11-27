<?php

namespace PaymentAuthorize\App\Controllers;

use PaymentAuthorize\Domain\PaymentAuthorize\DTO\AuthorizePaymentRequest;
use PaymentAuthorize\Domain\PaymentAuthorize\UseCase\IAuthorizePaymentUC;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Exception;

class PaymentAuthorizeContoller
{
    private IAuthorizePaymentUC $authorizePayment;
    
    public function __construct(IAuthorizePaymentUC $authorizePayment)
    {
        $this->authorizePayment = $authorizePayment;
    }
    
    public function authorize(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {            
            $paymentId = $request->getAttribute('payment_id');
            if (empty($paymentId)) {
                throw new Exception("Parameter 'payment_id' is invalid", 400);
            }
            
            $result = $this->authorizePayment->execute(new AuthorizePaymentRequest($paymentId));
            
            $response = $response->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode($result->toArray()));
            return $response;
        } catch (Exception $e) {
            $code = $e->getCode() ? $e->getCode() : 500;
            $result = [
                'code' => $code,
                'message' => $e->getMessage()
            ];
            
            $response = $response->withHeader('Content-Type', 'application/json');
            $response = $response->withStatus($code);
            $response->getBody()->write(json_encode($result));
            return $response;
        }        
    }
}
