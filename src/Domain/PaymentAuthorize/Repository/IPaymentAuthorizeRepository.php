<?php

namespace PaymentAuthorize\Domain\PaymentAuthorize\Repository;

use PaymentAuthorize\Domain\PaymentAuthorize\Entity\PaymentAuthorize;

interface IPaymentAuthorizeRepository
{
    public function findByPaymentId(string $paymentId): ?PaymentAuthorize;
}
