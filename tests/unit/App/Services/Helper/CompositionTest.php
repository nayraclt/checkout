<?php

use App\Services\Helper\Composition;

class CompositionTest extends \Raiadrogasil\Test\BaseTestCase
{
    private $mockComposition;

    public function setUp(): void
    {
        parent::setUp();

        $this->mockComposition = Mockery::mock(Composition::class, [[]])
            ->makePartial();
    }

    public function testWithPriceStockShipping()
    {
        $price = [
            "sku" => 45086,
            "valueFrom" => 11.99,
            "valueTo" => 8.99,
        ];

        $stock = [
            "sku" => 45086,
            "qty" => 11861
        ];

        $shipping = [
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
            "information" => "Compre mais R$ 440 e ganhe frete grátis  para a região Sudeste e Centro Oeste.
            Demais regiões o frete é grátis para compras acima de R$ 450.",
            "scheduledDelivery" => false,

        ];

        $this->mockComposition
            ->withPrice($price)
            ->withStock($stock)
            ->withQuoteShipping($shipping);

        $this->assertIsArray($this->mockComposition->get());
    }

    public function testGetWithoutPriceStockShipping()
    {
        $this->assertIsArray($this->mockComposition->get());
    }

    public function testPriceWithoutStockShippig()
    {
        $price = [
            "sku" => 45086,
            "valueFrom" => 11.99,
            "valueTo" => 8.99,
        ];

        $this->mockComposition->withPrice($price);

        $this->assertIsArray($this->mockComposition->get());
    }

    public function testPriceStockWithoutShipping()
    {
        $price = [
            "sku" => 45086,
            "valueFrom" => 11.99,
            "valueTo" => 8.99,
        ];

        $stock = [
            "sku" => 45086,
            "qty" => 11861
        ];

        $this->mockComposition->withPrice($price);
        $this->mockComposition->withStock($stock);

        $this->assertIsArray($this->mockComposition->get());
    }

    public function testCompositionDoNothingWithNoArguments()
    {
        $this->mockComposition->withPrice(null);
        $this->mockComposition->withStock(null);
        $this->mockComposition->withQuoteShipping(null);

        $result = $this->mockComposition->get();
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

}
