<?php

use App\Domain\DTO\ProductDTO;

class ShippingTest extends \Raiadrogasil\Test\BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testGetShippingQuote()
    {
        $productDTO = Mockery::mock(\App\Domain\DTO\ProductDTO::class)->makePartial();
        $productDTO->shouldReceive('getStoreName')->andReturn('DROGASIL');
        $productDTO->shouldReceive('getSku')->andReturn(123);
        $productDTO->shouldReceive('getZipcode')->andReturn(50123123);
        $productDTO->shouldReceive('getQty')->andReturn(1);
        $productDTO->shouldReceive('getValueTo')->andReturn(1.99);

        $responseDefaultDTO = Mockery::mock(\Raiadrogasil\Connect\DTO\ResponseDefaultDTO::class)->makePartial()
            ->shouldReceive('getResults')->andReturn(['results' => 'NA'])->getMock();

        $conn = Mockery::mock(\Raiadrogasil\Connect\ClientConnect::class)->makePartial();
        $conn->shouldReceive('send')->andReturn($responseDefaultDTO);

        $mock = Mockery::mock(\App\Services\Connect\Microservice\Shipping::class, [$conn])
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $result = $mock->getProductShippingQuote($productDTO);

        $this->assertEquals('NA', $result);
    }

    public function testResponseValidateReturnFail()
    {
        $productDTO = Mockery::mock(\App\Domain\DTO\ProductDTO::class)->makePartial();
        $productDTO->shouldReceive('getStoreName')->andReturn('DROGASIL');
        $productDTO->shouldReceive('getSku')->andReturn(1234);
        $productDTO->shouldReceive('getZipcode')->andReturn(54123123);
        $productDTO->shouldReceive('getQty')->andReturn(1);
        $productDTO->shouldReceive('getValueTo')->andReturn(1.99);

        $responseDefaultDTO = Mockery::mock(\Raiadrogasil\Connect\DTO\ResponseDefaultDTO::class)
            ->makePartial();

        $responseDefaultDTO->shouldReceive('isError')
            ->andReturn(true);

        $conn = Mockery::mock(\Raiadrogasil\Connect\ClientConnect::class)
            ->makePartial();

        $conn->shouldReceive('send')
            ->andReturn($responseDefaultDTO);

        $mock = Mockery::mock(\App\Services\Connect\Microservice\Shipping::class, [$conn])
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $mock->shouldReceive('buildBodyRequestOffer')
            ->andReturn(['NA']);

        $this->assertFalse(
            $mock->getProductShippingQuote($productDTO, [])
        );
    }

    public function testGetShippingQuoteWithoutZipcode()
    {
        $productDTO = Mockery::mock(\App\Domain\DTO\ProductDTO::class)->makePartial();
        $productDTO->shouldReceive('getStoreName')->andReturn('DROGASIL');
        $productDTO->shouldReceive('getSku')->andReturn(123);
        $productDTO->shouldReceive('getZipcode')->andReturn(null);

        $responseDefaultDTO = Mockery::mock(\Raiadrogasil\Connect\DTO\ResponseDefaultDTO::class)->makePartial()
            ->shouldReceive('getResults')->andReturn(['results' => 'NA'])->getMock();

        $conn = Mockery::mock(\Raiadrogasil\Connect\ClientConnect::class)->makePartial();
        $conn->shouldReceive('send')->andReturn($responseDefaultDTO);

        $mock = Mockery::mock(\App\Services\Connect\Microservice\Shipping::class, [$conn])->makePartial()->shouldAllowMockingProtectedMethods()
            ->shouldReceive('buildBodyRequestOffer')->andReturn(['NA'])->getMock();

        $result = $mock->getProductShippingQuote($productDTO);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testGetShippingQuoteWithoutQty()
    {
        $productDTO = Mockery::mock(\App\Domain\DTO\ProductDTO::class)->makePartial();
        $productDTO->shouldReceive('getStoreName')->andReturn('DROGASIL');
        $productDTO->shouldReceive('getSku')->andReturn(123);
        $productDTO->shouldReceive('getZipcode')->andReturn(50123123);
        $productDTO->shouldReceive('getQty')->andReturn(null);
        $productDTO->shouldReceive('valuetTo')->andReturn(null);

        $responseDefaultDTO = Mockery::mock(\Raiadrogasil\Connect\DTO\ResponseDefaultDTO::class)->makePartial()
            ->shouldReceive('getResults')->andReturn(['results' => 'NA'])->getMock();

        $conn = Mockery::mock(\Raiadrogasil\Connect\ClientConnect::class)->makePartial();
        $conn->shouldReceive('send')->andReturn($responseDefaultDTO);

        $mock = Mockery::mock(\App\Services\Connect\Microservice\Shipping::class, [$conn])->makePartial()->shouldAllowMockingProtectedMethods()
            ->shouldReceive('buildBodyRequestOffer')->andReturn(['NA'])->getMock();

        $result = $mock->getProductShippingQuote($productDTO);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testGetShippingQuoteWithoutValueTo()
    {
        $productDTO = Mockery::mock(\App\Domain\DTO\ProductDTO::class)->makePartial();
        $productDTO->shouldReceive('getStoreName')->andReturn('DROGASIL');
        $productDTO->shouldReceive('getSku')->andReturn(123);
        $productDTO->shouldReceive('getZipcode')->andReturn(50123123);
        $productDTO->shouldReceive('getQty')->andReturn(1);
        $productDTO->shouldReceive('valueTo')->andReturn(null);

        $responseDefaultDTO = Mockery::mock(\Raiadrogasil\Connect\DTO\ResponseDefaultDTO::class)->makePartial()
            ->shouldReceive('getResults')->andReturn(['results' => 'NA'])->getMock();

        $conn = Mockery::mock(\Raiadrogasil\Connect\ClientConnect::class)->makePartial();
        $conn->shouldReceive('send')->andReturn($responseDefaultDTO);

        $mock = Mockery::mock(\App\Services\Connect\Microservice\Shipping::class, [$conn])->makePartial()->shouldAllowMockingProtectedMethods()
            ->shouldReceive('buildBodyRequestOffer')->andReturn(['NA'])->getMock();

        $result = $mock->getProductShippingQuote($productDTO);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }
}
