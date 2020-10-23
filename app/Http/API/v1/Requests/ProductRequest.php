<?php

namespace App\Http\API\v1\Requests;

use App\Domain\DTO\ProductDTO;
use Raiadrogasil\Common\Request\BaseRequest;

class ProductRequest extends BaseRequest
{
    /**
     * Testa a validacao e retorna um DTO
     *
     * @param string $storeName
     * @return ProductDTO
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateFind($storeName)
    {
        $this->validateStore($storeName);

        //executar a validacao
        $rule = [
            'sku' => 'required|numeric|min:1',
            'zipcode' => 'zipcode',
            'qty' => 'numeric|min:1',
        ];
        $requestResource = $this->validateArr($rule, false);

        //parse para objeto DTO
        $productDTO = new ProductDTO($requestResource);
        $productDTO->setStoreName($storeName);

        return $productDTO;
    }

    /**
     * Testa a validacao e retorna um DTO
     *
     * @return ProductDTO
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateAdd()
    {
        //executar a validacao
        $rule = [];
        $requestResource = $this->validateArr($rule, false);

        //parse para objeto DTO
        $productDTO = new ProductDTO($requestResource);

        return $productDTO;
    }

    /**
     * Testa a validacao e retorna um DTO
     *
     * @return ProductDTO
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateUpdate()
    {
        //executar a validacao
        $rule = [];
        $requestResource = $this->validateArr($rule, true);

        //parse para objeto DTO
        $productDTO = new ProductDTO($requestResource);

        return $productDTO;
    }

    /**
     * Validações customizadas atribuidas a esse modulo
     * @codeCoverageIgnore
     */
    public function buildValidationRulesCustom()
    {
    }
}
