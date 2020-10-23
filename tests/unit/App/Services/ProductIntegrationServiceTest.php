<?php

use Raiadrogasil\Connect\ClientConnect;

class ProductIntegrationServiceTest extends \Raiadrogasil\Test\BaseTestCase
{
    private $mockProductDTO;

    private $clientConnection;

    private $mockPrice;

    private $mockStock;

    private $mockShipping;

    private $mockComposition;

    private $mockService;


    public function setUp(): void
    {
        parent::setUp();

        $this->mockProductDTO = Mockery::mock(App\Domain\DTO\ProductDTO::class)->makePartial();
        $this->mockProductDTO->shouldReceive('getStoreName')->andReturn('DROGASIL');
        $this->mockProductDTO->shouldReceive('getSku')->andReturn(1234);
        $this->mockProductDTO->shouldReceive('getZipcode')->andReturn(54123123);
        $this->mockProductDTO->shouldReceive('getQty')->andReturn(1);

        $responseDefaultDTO = Mockery::mock(\Raiadrogasil\Connect\Dto\ResponseDefaultDTO::class)->makePartial();

        $this->clientConnection = Mockery::mock(ClientConnect::class);
        $this->clientConnection->shouldReceive('setSaveLog', 'setMock', 'setThrowException')->andReturn($this->clientConnection);
        $this->clientConnection->shouldReceive('send')->andReturn($responseDefaultDTO);

        $this->mockComposition = Mockery::mock(\App\Services\Helper\Composition::class, [$this->clientConnection])->makePartial();
        $this->mockPrice = Mockery::mock(\App\Services\Connect\Microservice\Price::class, [$this->clientConnection])->makePartial();
        $this->mockStock = Mockery::mock(\App\Services\Connect\Microservice\Stock::class, [$this->clientConnection])->makePartial();
        $this->mockShipping = Mockery::mock(\App\Services\Connect\Microservice\Shipping::class, [$this->clientConnection])->makePartial();

        $this->mockService = Mockery::mock(\App\Services\ProductIntegrationService::class,[
            $this->mockComposition,
            $this->mockPrice,
            $this->mockStock,
            $this->mockShipping
        ])->makePartial();
    }

    public function testAllCheckoutData()
    {
        $this->mockComposition
            ->shouldReceive('withPrice', 'withStock', 'withQuoteShipping')
            ->andReturn($this->mockComposition);

        // $this->mockPrice
        //     ->shouldReceive('getProductPrice')
        //     ->andReturn(['sku' => 1]);

        // $this->mockStock
        //     ->shouldReceive('getProductStock')
        //     ->andReturn(['sku' => 1]);

        // $this->mockShipping
        //     ->shouldReceive('getProductShippingQuote')
        //     ->andReturn(['value' => 1]);

        $this->mockComposition
            ->shouldReceive('get')
            ->andReturn([]);

        $this->mockProductDTO->shouldReceive('setValueTo')->andReturn(null);

        $this->assertIsArray($this->mockService->allCheckoutData($this->mockProductDTO));
    }

    public function testAllCheckoutDataSetValueTo()
    {
        $mockPrice = Mockery::mock(\App\Services\Connect\Microservice\Price::class, [$this->clientConnection])->makePartial();
        $mockPrice->shouldReceive('getProductPrice')
            ->andReturn(['valueTo' => 1.23]);

        $mockService = Mockery::mock(\App\Services\ProductIntegrationService::class,[
            $this->mockComposition,
            $mockPrice,
            $this->mockStock,
            $this->mockShipping
        ])->makePartial();

        $this->mockComposition
            ->shouldReceive('withPrice', 'withStock', 'withQuoteShipping')
            ->andReturn($this->mockComposition);

        $this->mockComposition
            ->shouldReceive('get')
            ->andReturn([]);

        $this->mockProductDTO->shouldReceive('setValueTo')->andReturn(null);

        $this->assertIsArray($mockService->allCheckoutData($this->mockProductDTO));
    }

    public function testPriceStockShippingShouldReturnFalse()
    {
        $this->mockComposition
            ->shouldReceive('withPrice', 'withStock', 'withQuoteShipping')
            ->andReturn($this->mockComposition);

        $this->mockPrice
            ->shouldReceive('getProductPrice')
            ->andReturn(null);

        $this->mockStock
            ->shouldReceive('getProductStock')
            ->andReturn(null);

        $this->mockShipping
            ->shouldReceive('getProductShippingQuote')
            ->andReturn(null);

        $this->mockComposition
            ->shouldReceive('get')
            ->andReturn([]);

        $this->assertIsArray($this->mockService->allCheckoutData($this->mockProductDTO));
    }
}
