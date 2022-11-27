<?php

namespace PaymentAuthorize\Domain\PaymentAuthorize\DTO;

class AuthorizePaymentRequest
{
    public string $paymentId;
    
    public function __construct(string $paymentId)
    {
        $this->paymentId = $paymentId;
    }
}
