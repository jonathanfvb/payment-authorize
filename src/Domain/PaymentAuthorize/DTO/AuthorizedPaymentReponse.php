<?php

namespace PaymentAuthorize\Domain\PaymentAuthorize\DTO;

class AuthorizedPaymentReponse
{
    public string $paymentId;
    
    public string $authorizedDate;
    
    public function __construct(string $paymentId, string $authorizedDate)
    {
        $this->paymentId = $paymentId;
        $this->authorizedDate = $authorizedDate;
    }
    
    public function toArray(): array
    {
        return [
            'payment_id' => $this->paymentId,
            'authorized_date' => $this->authorizedDate
        ];
    }
}
