<?php

namespace PaymentAuthorize\Domain\PaymentAuthorize\UseCase;

use PaymentAuthorize\Domain\PaymentAuthorize\DTO\AuthorizePaymentRequest;
use PaymentAuthorize\Domain\PaymentAuthorize\DTO\AuthorizedPaymentReponse;
use PaymentAuthorize\Domain\PaymentAuthorize\Repository\IPaymentAuthorizeRepository;
use \Exception;

class AuthorizePaymentUC
{
    private IPaymentAuthorizeRepository $paymentAuthorizeRepository;
    
    public function __construct(
        IPaymentAuthorizeRepository $paymentAuthorizeRepository
    ) {
        $this->paymentAuthorizeRepository = $paymentAuthorizeRepository;
    }
    
    public function execute(AuthorizePaymentRequest $request): AuthorizedPaymentReponse
    {
        $paymentAuthorize = $this->paymentAuthorizeRepository->findByPaymentId($request->paymentId);
        if ($paymentAuthorize == null) {
            throw new Exception("Payment not found");
        }
        if ($paymentAuthorize->authorized) {
            throw new Exception("Payment is already authorized");
        }
        
        $authorizedDate = new \DateTime();
        return new AuthorizedPaymentReponse($request->paymentId, $authorizedDate->format('Y-m-d H:i:s'));
    }
}
