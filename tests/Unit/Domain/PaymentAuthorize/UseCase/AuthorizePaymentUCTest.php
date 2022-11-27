<?php

namespace Tests\Unit\Domain\PaymentAuthorize\UseCase;

use PHPUnit\Framework\TestCase;
use PaymentAuthorize\Domain\PaymentAuthorize\UseCase\AuthorizePaymentUC;
use PaymentAuthorize\Domain\PaymentAuthorize\Repository\IPaymentAuthorizeRepository;
use PaymentAuthorize\Domain\PaymentAuthorize\DTO\AuthorizePaymentRequest;
use PaymentAuthorize\Domain\PaymentAuthorize\Entity\PaymentAuthorize;
use PaymentAuthorize\Domain\PaymentAuthorize\DTO\AuthorizedPaymentReponse;

final class AuthorizePaymentUCTest extends TestCase
{
    public function testWhenPaymentIsNotFoundShouldThrowsException(): void
    {
        // ARRANGE
        $paymentAuthorizeRepository = $this->createMock(IPaymentAuthorizeRepository::class);
        $paymentAuthorizeRepository->method('findByPaymentId')->willReturn(null);
        
        $authorizePayment = new AuthorizePaymentUC($paymentAuthorizeRepository);
        
        // ACT && ASSERT
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Payment not found");
        
        $authorizePayment->execute(new AuthorizePaymentRequest("123"));
    }
    
    public function testWhenPaymentIsAlreadyAuthorizedThrowsException(): void
    {
        // ARRANGE
        $paymentId = "123";
        $paymentAuthorized = new PaymentAuthorize($paymentId, true);
        $paymentAuthorizeRepository = $this->createMock(IPaymentAuthorizeRepository::class);
        $paymentAuthorizeRepository->method('findByPaymentId')->willReturn($paymentAuthorized);
        
        $authorizePayment = new AuthorizePaymentUC($paymentAuthorizeRepository);
        
        // ACT && ASSERT
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Payment is already authorized");
        
        $authorizePayment->execute(new AuthorizePaymentRequest($paymentId));
    }
    
    public function testWhenPaymentIsNotAuthorizedShouldPerformSuccess(): void
    {
        // ARRANGE
        $paymentId = "123";
        $paymentAuthorized = new PaymentAuthorize($paymentId, false);
        $paymentAuthorizeRepository = $this->createMock(IPaymentAuthorizeRepository::class);
        $paymentAuthorizeRepository->method('findByPaymentId')->willReturn($paymentAuthorized);
        
        $authorizePayment = new AuthorizePaymentUC($paymentAuthorizeRepository);
        
        // ACT
        $response = $authorizePayment->execute(new AuthorizePaymentRequest($paymentId));
        
        // ASSERT
        $this->assertInstanceOf(AuthorizedPaymentReponse::class, $response);
        $this->assertObjectHasAttribute('paymentId', $response);
        $this->assertObjectHasAttribute('authorizedDate', $response);
    }
}
