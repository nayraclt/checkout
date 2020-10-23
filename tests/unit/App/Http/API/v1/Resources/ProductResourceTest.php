<?php

class ProductResourceTest extends \Raiadrogasil\Test\BaseTestCase
{
    use \Raiadrogasil\Test\Traits\TestResource;

    public function resourceClass()
    {
        return \App\Http\API\v1\Resources\ProductResource::class;
    }
}
