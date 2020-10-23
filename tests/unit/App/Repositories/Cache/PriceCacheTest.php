<?php

class PriceCacheTest extends \Raiadrogasil\Test\BaseTestCase
{
    public function testGetBuildKey()
    {
        $mockCache = Mockery::mock(\App\Repositories\Cache\PriceCache::class)->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $result = $mockCache->getBuildKey('NA', 'NA');
        $this->assertEquals('price_na_na', $result);
    }

    public function testGetPriceShouldNullToCacheNull()
    {
        $redis = Mockery::mock(Raiadrogasil\Util\Services\UtilRedis::class)
            ->shouldReceive('hMGet', 'hGet', 'hGetAll', 'get')->andReturn(null)->getMock();

        $mockCache = Mockery::mock(\App\Repositories\Cache\PriceCache::class, [$redis])->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $result = $mockCache->getPrice('NA', 42);
        $this->assertNull($result);
    }

    public function testGetPrice()
    {
        $expectedResult = [
            "sku" => 45086,
            "valueFrom" => 11.99,
            "valueTo" => 8.99,
        ];

        $redis = Mockery::mock(Raiadrogasil\Util\Services\UtilRedis::class)
            ->shouldReceive('hGetAll')->andReturn($expectedResult)->getMock();

        $mockCache = Mockery::mock(\App\Repositories\Cache\PriceCache::class, [$redis])->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $result = $mockCache->getPrice('NA', 45086);
        $this->assertIsArray($result);
        $this->assertSame($expectedResult, $result);
    }


    public function testPutPriceShouldNullToArrayNull()
    {
        $redis = Mockery::mock(Raiadrogasil\Util\Services\UtilRedis::class)
            ->shouldReceive('hMSet')->andReturn(null)->getMock();

        $mockCache = Mockery::mock(\App\Repositories\Cache\PriceCache::class, [$redis])->makePartial()->shouldAllowMockingProtectedMethods();

        $result = $mockCache->putPrice('NA', 'NA', []);
        $this->assertNull($result);
    }

    public function testForgetPrice()
    {
        $redis = Mockery::mock(Raiadrogasil\Util\Services\UtilRedis::class)->makePartial()
            ->shouldReceive('clear')->andReturn(true)->getMock();

        $mockCache = Mockery::mock(\App\Repositories\Cache\PriceCache::class, [$redis])->makePartial();

        $result = $mockCache->forgetPrice('NA');
        $this->assertIsBool($result);
    }

    public function testHasPrice()
    {
        $redis = Mockery::mock(\Raiadrogasil\Util\Services\UtilRedis::class)->makePartial()
            ->shouldReceive('exists')->andReturn(true)->getMock();

        $mockCache = Mockery::mock(\App\Repositories\Cache\PriceCache::class, [$redis])->makePartial();

        $result = $mockCache->hasPrice('NA', 'NA');
        $this->assertIsBool($result);
    }
}
