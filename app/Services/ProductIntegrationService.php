<?php

namespace App\Services;

use App\Domain\DTO\ProductDTO;
use Raiadrogasil\Common\Service\BaseService;
use App\Services\Connect\Microservice\Price;
use App\Services\Connect\Microservice\Shipping;
use App\Services\Connect\Microservice\Stock;
use App\Services\Helper\Composition;

class ProductIntegrationService extends BaseService implements ProductIntegrationServiceInterface
{
    /**
     * @var Composition;
     */
    private $composition;

    /**
     * @var Price
     */
    private $priceConn;

    /**
     * @var Stock
     */
    private $stockConn;

    /**
     * @var Shipping
     */
    private $shippingConn;


    /**
     * ProductIntegrationService constructor
     *
     * @param Price $priceConn
     * @param Stock $stockConn
     * @param Shipping $shippingConn
     * @param Composition $composition
     */
    public function __construct(
        Composition $composition,
        Price $priceConn,
        Stock $stockConn,
        Shipping $shippingConn
    ) {
        $this->composition = $composition;
        $this->priceConn = $priceConn;
        $this->stockConn = $stockConn;
        $this->shippingConn = $shippingConn;
    }

    /**
     * Buscar dados do checkout
     *
     * @param \App\Domain\DTO\ProductDTO $productDTO
     *
     * @return array|null
     */
    public function allCheckoutData(ProductDTO $productDTO): ?array
    {
        $priceData = $this->priceConn->getProductPrice($productDTO);
        $stockData = $this->stockConn->getProductStock($productDTO);

        if ($priceData) {
            $productDTO->setValueTo($priceData['valueTo']);
        }

        $shippingQuoteData = $this->shippingConn->getProductShippingQuote($productDTO);

        return $this->composition
            ->withPrice($priceData)
            ->withStock($stockData)
            ->withQuoteShipping($shippingQuoteData)
            ->get();
    }
}
