<?php

namespace PaymentAuthorize\Domain\PaymentAuthorize\Repository;

use PaymentAuthorize\Domain\PaymentAuthorize\Entity\PaymentAuthorize;

class PaymentAuthorizeRepository implements IPaymentAuthorizeRepository
{

    public function findByPaymentId($paymentId): ?PaymentAuthorize
    {
        return null;
    }
}
