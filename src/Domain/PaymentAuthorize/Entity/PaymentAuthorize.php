<?php

namespace PaymentAuthorize\Domain\PaymentAuthorize\Entity;

class PaymentAuthorize
{
    public string $paymentId;
    
    public bool $authorized;
    
    public function __construct(
        string $paymentId,
        bool $authorized
    ) {
        $this->paymentId = $paymentId;
        $this->authorized = $authorized;
    }
}
