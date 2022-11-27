<?php

namespace PaymentAuthorize\Domain\PaymentAuthorize\UseCase;

use PaymentAuthorize\Domain\PaymentAuthorize\DTO\AuthorizePaymentRequest;
use PaymentAuthorize\Domain\PaymentAuthorize\DTO\AuthorizedPaymentReponse;

interface IAuthorizePaymentUC
{
    public function execute(AuthorizePaymentRequest $request): AuthorizedPaymentReponse;
}
