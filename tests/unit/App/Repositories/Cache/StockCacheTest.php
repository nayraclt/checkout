<?php

class StockCacheTest extends \Raiadrogasil\Test\BaseTestCase
{
    public function testGetBuildKey()
    {
        $mockCache = Mockery::mock(\App\Repositories\Cache\StockCache::class)->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $result = $mockCache->getBuildKey('NA', 'NA');
        $this->assertEquals('stock_na_na', $result);
    }

    public function testGetStockShouldNullToCacheNull()
    {
        $redis = Mockery::mock(Raiadrogasil\Util\Services\UtilRedis::class)
            ->shouldReceive('hGetAll')->andReturn(null)->getMock();

        $mockCache = Mockery::mock(\App\Repositories\Cache\StockCache::class, [$redis])->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $result = $mockCache->getStock('NA', 42);
        $this->assertNull($result);
    }

    public function testGetStock()
    {
        $expectedResult = [
            "sku" => 45086,
            "qty" => 11861
        ];

        $redis = Mockery::mock(Raiadrogasil\Util\Services\UtilRedis::class)
            ->shouldReceive('hGetAll')->andReturn($expectedResult)->getMock();

        $mockCache = Mockery::mock(\App\Repositories\Cache\StockCache::class, [$redis])->makePartial()
            ->shouldAllowMockingProtectedMethods();

        $result = $mockCache->getStock('NA', 45086);
        $this->assertIsArray($result);
        $this->assertSame($expectedResult, $result);
    }


    public function testPutStockhouldNullToArrayNull()
    {
        $redis = Mockery::mock(Raiadrogasil\Util\Services\UtilRedis::class)
            ->shouldReceive('hMSet')->andReturn(null)->getMock();

        $mockCache = Mockery::mock(\App\Repositories\Cache\StockCache::class, [$redis])->makePartial()->shouldAllowMockingProtectedMethods();

        $result = $mockCache->putStock('NA', 'NA', []);
        $this->assertNull($result);
    }

    public function testForgetStock()
    {
        $redis = Mockery::mock(Raiadrogasil\Util\Services\UtilRedis::class)->makePartial()
            ->shouldReceive('clear')->andReturn(true)->getMock();

        $mockCache = Mockery::mock(\App\Repositories\Cache\StockCache::class, [$redis])->makePartial();

        $result = $mockCache->forgetStock('NA');
        $this->assertIsBool($result);
    }

    public function testHasStock()
    {
        $redis = Mockery::mock(\Raiadrogasil\Util\Services\UtilRedis::class)->makePartial()
            ->shouldReceive('exists')->andReturn(true)->getMock();

        $mockCache = Mockery::mock(\App\Repositories\Cache\StockCache::class, [$redis])->makePartial();

        $result = $mockCache->hasStock('NA', 'NA');
        $this->assertIsBool($result);
    }
}
