<?php

namespace App\Services;

use Raiadrogasil\Common\Service\BaseService;
use App\Domain\DTO\ProductDTO;

class ProductService extends BaseService implements ProductServiceInterface
{
    /**
     * @var ProductIntegrationService
     */
    private $productIntegrationService;


    public function __construct(ProductIntegrationService $productIntegrationService)
    {
        $this->productIntegrationService = $productIntegrationService;
    }

    /**
     * Buscar dados do checkout
     *
     * @param \App\Domain\DTO\ProductDTO $productDTO
     * @return array|null
     * @throws Exception
     */
    public function allCheckoutData(ProductDTO $productDTO): ?array
    {
        return $this->productIntegrationService->allCheckoutData($productDTO);
    }
}
