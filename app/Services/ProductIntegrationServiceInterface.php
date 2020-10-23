<?php

namespace App\Services;

use App\Domain\DTO\ProductDTO;

interface ProductIntegrationServiceInterface
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
