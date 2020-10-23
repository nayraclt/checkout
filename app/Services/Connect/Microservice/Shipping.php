<?php

namespace App\Services\Connect\Microservice;

use App\Domain\DTO\ProductDTO;
use App\Util\Enum\EnumConfiguration;
use Raiadrogasil\Connect\ClientConnect;
use Raiadrogasil\Connect\DTO\RequestDTO;
use Raiadrogasil\Connect\DTO\ResponseDefaultDTO;
use Raiadrogasil\Connect\Enum\EnumVerbRequest;

class Shipping
{
    /**
     * @var ClientConnect
     */
    private $clientConnect;

    public function __construct(ClientConnect $clientConnect)
    {
        $this->clientConnect = $clientConnect;
    }

    /**
     * Buscar cotação do frete para o produto
     *
     * @param ProductDTO $productDTO
     * @return array|false
     * @throws \Exception
     */
    public function getProductShippingQuote(ProductDTO $productDTO)
    {
        $storeName = $productDTO->getStoreName();
        $sku = $productDTO->getSku();
        $zipcode = $productDTO->getZipcode();
        $qty = $productDTO->getQty();
        $valueTo = $productDTO->getValueTo();

        if (!$zipcode || !$qty || !$valueTo) {
            return [];
        }

        $requestDTO = $this->buildRequest($storeName, $sku, $zipcode, $qty, $valueTo);

        $responseDTO = $this->sendRequest($requestDTO);
        if ($responseDTO->isError()) {
            return false;
        }

        return $responseDTO->getResults()['results'];
    }

    /**
     * @param string $storeName
     * @param int $sku
     * @param int $zipcode
     * @param int $qty
     * @param float $valueTo
     *
     * @return \Raiadrogasil\Connect\DTO\RequestDTO
     */
    public function buildRequest(string $storeName, int $sku, int $zipcode, int $qty, float $valueTo): RequestDTO
    {
        $configUriApi = configuration(EnumConfiguration::MS_GROUP, EnumConfiguration::RD_URI_API_SHIPPING_QUOTE);

        $configUriApi = \sprintf($configUriApi, $storeName);

        return (new RequestDTO(EnumVerbRequest::POST, $configUriApi))
            ->setQueryString('traceId', getTraceId())
            ->setQueryString('sku', $sku)
            ->setBodyRequest([
                "storeName" => $storeName,
                "channel" => "NA",
                "zipCode" => $zipcode,
                "product" => [[
                    "sku" => $sku,
                    "qty" => $qty,
                    "onHealth" => 1,
                    "valueTo" => $valueTo,
                ]]
            ])
            ->setTimeOut(2);
    }

    /**
     * @param RequestDTO $requestDTO
     *
     * @return ResponseDefaultDTO
     */
    public function sendRequest($requestDTO): ResponseDefaultDTO
    {
        $configApiLog = configuration(EnumConfiguration::MS_GROUP, EnumConfiguration::ACTIVATE_LOG_API_SHIPPING);

        return $this->clientConnect
            ->setSaveLog(boolval($configApiLog))
            ->setMock('shipping.json', true)
            ->setThrowException(false)
            ->send($requestDTO);
    }
}
