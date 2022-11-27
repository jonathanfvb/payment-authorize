<?php

namespace PaymentAuthorize\App\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class PaymentAuthorizeContoller
{
    
    
    public function authorize(ServerRequestInterface $request, ResponseInterface $response)
    {
        $paymentId = $request->getAttribute('payment_id');
        $payload = [
            'payment_id' => $paymentId
        ];
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode($payload));
        return $response;
    }
}
