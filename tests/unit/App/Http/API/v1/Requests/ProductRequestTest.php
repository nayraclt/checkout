<?php

use App\Domain\DTO\ProductDTO;

class ProductRequestTest extends \Raiadrogasil\Test\BaseTestCase
{
    use \Raiadrogasil\Test\Traits\TestRequest;

    public function requestClass()
    {
        return \App\Http\API\v1\Requests\ProductRequest::class;
    }

    /**
     * @dataProvider getProvider
     */
    public function testValidateFind($expectedValue, $arrParameters)
    {
        if ($arrParameters['isException'])
            $this->expectException(\Exception::class);

        $instance = $this->mockResource($this->requestClass(), $arrParameters['isException']);
        $instance->shouldAllowMockingProtectedMethods()
            ->shouldReceive('getResouceAllData')
            ->andReturn([]);

        $method = $instance->shouldAllowMockingProtectedMethods()
            ->shouldReceive('validateVars')
            ->andReturn(true);

        if ($arrParameters['isException'])
            $method->andThrow(new \Exception('NA'));

        $storeName = 'DROGASIL';
        $return = $instance->validateFind($storeName);

        $this->assertInstanceOf(\Raiadrogasil\Common\DTO\BaseDTO::class, $return);
    }

}
