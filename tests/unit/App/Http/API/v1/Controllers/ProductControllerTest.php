<?php

class ProductControllerTest extends \Raiadrogasil\Test\BaseTestCase
{
    private $mockRequest;

    private $mockReturnDTO;

    public function setUp(): void
    {
        parent::setUp();

        $this->mockInit();
    }

    protected function mockInit()
    {
        $this->mockRequest = \Mockery::mock(\App\Http\API\v1\Requests\ProductRequest::class)->makePartial();
        $this->mockRequest->shouldAllowMockingProtectedMethods()->shouldReceive('validateStore', 'validateId', 'validateRequired', 'validateArr')->andReturn(true);
        $this->mockRequest->shouldReceive('validateFind', 'validateUpdate', 'validateAdd')->andReturn(new \App\Domain\DTO\ProductDTO());

        $this->mockReturnDTO = \Mockery::mock(\Raiadrogasil\Common\DTO\ReturnDTO::class)->makePartial();
        $this->mockReturnDTO->shouldReceive('count')->andReturn(1);
    }

    public function clsMockController($returnController, $returnService, $isThrowException)
    {
        $mockService = Mockery::mock(\App\Services\ProductService::class)->makePartial();

        $methodAll = $mockService->shouldReceive('allCheckoutData')->andReturn($returnService);
        if ($isThrowException)
            $methodAll->andThrow(new \Exception('NA'));

        $fakeMock = \Mockery::mock('FakeMock')->shouldReceive('configureMainParser')->andReturn(true)->getMock();

        $mock = \Mockery::mock(\App\Http\API\v1\Controllers\ProductController::class, [$mockService])->makePartial();
        $mock->shouldAllowMockingProtectedMethods()->shouldReceive('response')->andReturn($returnController)->getMock();
        $mock->shouldAllowMockingProtectedMethods()->shouldReceive('resource')->andReturn($fakeMock)->getMock();
        return $mock;
    }


    public function getProvider()
    {
        $collection = [
            'results' => [
                'price' => [
                    "sku" => 45086,
                    "valueFrom" => 11.99,
                    "valueTo" => 8.99,
                ],
                'stock' => [
                    "sku" => 45086,
                    "qty" => 11861,
                ],
                'shipping' => [
                    "value" => 9.73,
                    "baseCost" => 9.73,
                    "flow" => "CD",
                    "id" => "2",
                    "estimateDays" => 2,
                    "idSubsidiary" => 3077,
                    "origin" => "intelipost",
                    "label" => [
                        "default" => "Rápida",
                        "deadline" => "Rápida - 2 dia(s) útil(eis)",
                        "success" => "Rápida - 2 dia(s) útil(eis)",
                        "informative" => "Rápida - 2 dia(s) útil(eis)"
                    ],
                    "oms" => [
                        "carrier" => 1,
                        "service" => 2
                    ],
                    "shiftDelivery" => [],
                    "information" => "Compre mais R$ 440 e ganhe frete grátis...",
                    "scheduledDelivery" => false,
                ]
            ],
            'traceId' => 'eee48cf4c80b8ef8106959d683caad7b',
        ];

        return [
            'shouldTrueToException' => ['expectedValue' => false, 'arrParameters' => ['returnService' => false, 'isException' => true]],
            'shouldTrue' => ['expectedValue' => true, 'arrParameters' => ['returnService' => $collection, 'isException' => false]],
        ];
    }


    public function getProviderWithId()
    {
        return [
            'shouldTrueToException' => ['expectedValue' => false, 'arrParameters' => ['returnService' => true, 'isException' => true, 'id' => 1]],
            'shouldTrue' => ['expectedValue' => true, 'arrParameters' => ['returnService' => true, 'isException' => true, 'id' => 1]],
            'shouldFalseToReturnFalseInService' => ['expectedValue' => false, 'arrParameters' => ['returnService' => false, 'isException' => false, 'id' => 1]],
            'shouldFalseToIdFalse' => ['expectedValue' => false, 'arrParameters' => ['returnService' => true, 'isException' => false, 'id' => 0]],
        ];
    }


    /**
     * @dataProvider getProvider
     */
    public function testAll($expectedValue, $arrParameters)
    {
        $isException = $arrParameters['isException'];

        if ($isException)
            $this->expectException(\Exception::class);

        $returnService = [1, 1];
        $storeName = 'DROGASIL';

        $result = $this
            ->clsMockController($expectedValue, $returnService, $isException)
            ->all($storeName, $this->mockRequest);

        $this->assertEquals($expectedValue, $result);
    }
}
