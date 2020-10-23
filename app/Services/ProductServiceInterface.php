<?php

namespace App\Services;

use Illuminate\Http\Request;
use Raiadrogasil\Common\DTO\ReturnDTO;
use App\Domain\DTO\ProductDTO;

interface ProductServiceInterface
{

    /**
     * Buscar dados do checkout
     *
     * @param \App\Domain\DTO\ProductDTO $productDTO
     * @return array|null
     * @throws Exception
     */
    public function allCheckoutData(ProductDTO $productDTO): ?array;
}
