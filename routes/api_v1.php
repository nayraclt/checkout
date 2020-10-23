<?php


$router->group(
    [
        'prefix' => 'api/v1/checkout',
        'middleware' => 'json_response'
    ], function ($router) {
            $router->get('/{storeName}/product', 'ProductController@all');
        }
);
