<?php

namespace Tests\Unit\App\Controller;

use PHPUnit\Framework\TestCase;
use PaymentAuthorize\Domain\PaymentAuthorize\UseCase\IAuthorizePaymentUC;
use PaymentAuthorize\App\Controllers\PaymentAuthorizeContoller;
use Psr\Http\Message\ServerRequestInterface;
use GuzzleHttp\Psr7\Response;

final class PaymentAuthorizeContollerTest extends TestCase
{
    public function testWhenPaymentIdIsInvalidShouldReturnWithStatus400()
    {
        // ARRANGE
        $authorizePayment = $this->createMock(IAuthorizePaymentUC::class);
        $controller = new PaymentAuthorizeContoller($authorizePayment);
        
        $request = $this->createMock(ServerRequestInterface::class);
        $request->method('getAttribute')
                ->withAnyParameters()
                ->willReturn(null);
        
        $response = new Response();
        
        // ACT
        $result = $controller->authorize($request, $response);
        
        // ASSERT
        $expectedPayload = [
            'code' => 400,
            'message' => "Parameter 'payment_id' is invalid"
        ];
        $this->assertEquals(400, $result->getStatusCode());
        $this->assertEquals(json_encode($expectedPayload), $result->getBody());
    }
}
