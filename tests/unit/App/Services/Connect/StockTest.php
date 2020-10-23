<?php

use App\Domain\DTO\ProductDTO;

class StockTest extends \Raiadrogasil\Test\BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testGetProductStock()
    {
        $productDTO = Mockery::mock(\App\Domain\DTO\ProductDTO::class)->makePartial();
        $productDTO->shouldReceive('getStoreName')->andReturn('DROGASIL');
        $productDTO->shouldReceive('getSku')->andReturn(123);

        $responseDefaultDTO = Mockery::mock(\Raiadrogasil\Connect\DTO\ResponseDefaultDTO::class)->makePartial()
            ->shouldReceive('getResults')->andReturn(['results' => 'NA'])->getMock();

        $conn = Mockery::mock(\Raiadrogasil\Connect\ClientConnect::class)->makePartial();
        $conn->shouldReceive('send')->andReturn($responseDefaultDTO);

        $mock = Mockery::mock(\App\Services\Connect\Microservice\Stock::class, [$conn])->makePartial()->shouldAllowMockingProtectedMethods()
            ->shouldReceive('buildBodyRequestOffer')->andReturn(['NA'])->getMock();

        $result = $mock->getProductStock($productDTO);
        $this->assertEquals('NA', $result);
    }

    public function testResponseValidateReturnFail()
    {
        $productDTO = Mockery::mock(\App\Domain\DTO\ProductDTO::class)->makePartial();
        $productDTO->shouldReceive('getStoreName')->andReturn('DROGASIL');
        $productDTO->shouldReceive('getSku')->andReturn(1234);

        $responseDefaultDTO = Mockery::mock(\Raiadrogasil\Connect\DTO\ResponseDefaultDTO::class)
            ->makePartial();

        $responseDefaultDTO->shouldReceive('isError')
            ->andReturn(true);

        $conn = Mockery::mock(\Raiadrogasil\Connect\ClientConnect::class)
            ->makePartial();

        $conn->shouldReceive('send')
            ->andReturn($responseDefaultDTO);

        $mock = Mockery::mock(\App\Services\Connect\Microservice\Stock::class, [$conn])
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $mock->shouldReceive('buildBodyRequestOffer')
            ->andReturn(['NA']);

        $this->assertFalse(
            $mock->getProductStock($productDTO, [])
        );
    }
}
