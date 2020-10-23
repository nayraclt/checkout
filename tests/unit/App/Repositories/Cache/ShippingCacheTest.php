<?php

class ShippingCacheTest extends \Raiadrogasil\Test\BaseTestCase
{
    public function testGetBuildKey()
    {
        $mockCache = Mockery::mock(\App\Repositories\Cache\ShippingCache::class)->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $result = $mockCache->getBuildKey('NA', 'NA');
        $this->assertEquals('shipping_na_na', $result);
    }

    public function testGetShippingQuoteShouldNullToCacheNull()
    {
        $redis = Mockery::mock(Raiadrogasil\Util\Services\UtilRedis::class)
            ->shouldReceive('hGetAll')->andReturn(null)->getMock();

        $mockCache = Mockery::mock(\App\Repositories\Cache\ShippingCache::class, [$redis])->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $result = $mockCache->getShippingQuote('NA', 1234, 54123123, 1);
        $this->assertNull($result);
    }

    public function testGetShippingQuote()
    {
        $expectedResult = [
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
            "information" => "Compre mais R$ 440 e ganhe frete grátis  para a região Sudeste e Centro Oeste.",
            "scheduledDelivery" => false
        ];

        $redis = Mockery::mock(Raiadrogasil\Util\Services\UtilRedis::class)
            ->shouldReceive('hGetAll')->andReturn($expectedResult)->getMock();

        $mockCache = Mockery::mock(\App\Repositories\Cache\ShippingCache::class, [$redis])->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $result = $mockCache->getShippingQuote('NA', 45086, 54123123, 1);
        $this->assertIsArray($result);
        $this->assertSame($expectedResult, $result);
    }

    public function testPutShippingQuotehouldNullToArrayNull()
    {
        $redis = Mockery::mock(Raiadrogasil\Util\Services\UtilRedis::class)
            ->shouldReceive('hmSet')->andReturn(null)->getMock();

        $mockCache = Mockery::mock(\App\Repositories\Cache\ShippingCache::class, [$redis])->makePartial()->shouldAllowMockingProtectedMethods();

        $result = $mockCache->putShippingQuote('NA', 1234, 54123123, 1, []);
        $this->assertNull($result);
    }

    public function testForgetShippingQuote()
    {
        $redis = Mockery::mock(Raiadrogasil\Util\Services\UtilRedis::class)->makePartial()
            ->shouldReceive('clear')->andReturn(true)->getMock();

        $mockCache = Mockery::mock(\App\Repositories\Cache\ShippingCache::class, [$redis])->makePartial();

        $result = $mockCache->forgetShippingQuote('NA');
        $this->assertIsBool($result);
    }

    public function testHasShippingQuote()
    {
        $redis = Mockery::mock(\Raiadrogasil\Util\Services\UtilRedis::class)->makePartial()
            ->shouldReceive('exists')->andReturn(true)->getMock();

        $mockCache = Mockery::mock(\App\Repositories\Cache\ShippingCache::class, [$redis])->makePartial();

        $result = $mockCache->hasShippingQuote('NA', 1234, 54123123, 1);
        $this->assertIsBool($result);
    }
}
