<?php

class ProductServiceTest extends \Raiadrogasil\Test\BaseTestCase
{
    private $mockProductDTO;

    private $mockProductIntegrationService;

    private $mockService;


    public function setUp(): void
    {
        parent::setUp();

        $this->mockProductDTO = Mockery::mock(App\Domain\DTO\ProductDTO::class)->makePartial();

        $this->mockProductIntegrationService = Mockery::mock(App\Services\ProductIntegrationService::class)->makePartial();

        $this->mockService = Mockery::mock(\App\Services\ProductService::class,[
            $this->mockProductIntegrationService,
        ])->makePartial();
    }

    public function testAllCheckoutData()
    {
        $this->mockProductIntegrationService
            ->shouldReceive('allCheckoutData')
            ->andReturn([]);

        $this->assertIsArray($this->mockService->allCheckoutData($this->mockProductDTO));
    }
}
