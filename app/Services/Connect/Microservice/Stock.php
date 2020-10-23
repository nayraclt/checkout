<?php

namespace App\Services\Connect\Microservice;

use App\Domain\DTO\ProductDTO;
use App\Util\Enum\EnumConfiguration;
use Raiadrogasil\Connect\ClientConnect;
use Raiadrogasil\Connect\DTO\RequestDTO;
use Raiadrogasil\Connect\DTO\ResponseDefaultDTO;
use Raiadrogasil\Connect\Enum\EnumVerbRequest;

class Stock
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
     * Buscar estoque do produto
     *
     * @param ProductDTO $productDTO
     * @return array|false
     * @throws \Exception
     */
    public function getProductStock(ProductDTO $productDTO)
    {
        $storeName = $productDTO->getStoreName();
        $sku = $productDTO->getSku();

        $requestDTO = $this->buildRequest($storeName, $sku);

        $responseDTO = $this->sendRequest($requestDTO);
        if ($responseDTO->isError()) {
            return false;
        }

        return $responseDTO->getResults()['results'];
    }

    /**
     * @param string $storeName
     * @param int $sku
     *
     * @return \Raiadrogasil\Connect\DTO\RequestDTO
     */
    public function buildRequest(string $storeName, int $sku): RequestDTO
    {
        $configUriApi = configuration(EnumConfiguration::MS_GROUP, EnumConfiguration::RD_URI_API_STOCK_PRODUCT);

        $configUriApi = \sprintf($configUriApi, $storeName);

        return (new RequestDTO(EnumVerbRequest::GET, $configUriApi))
            ->setQueryString('traceId', getTraceId())
            ->setQueryString('sku', $sku)
            ->setTimeOut(2);
    }

    /**
     * @param RequestDTO $requestDTO
     *
     * @return ResponseDefaultDTO
     */
    public function sendRequest($requestDTO): ResponseDefaultDTO
    {
        $configApiLog = configuration(EnumConfiguration::MS_GROUP, EnumConfiguration::ACTIVATE_LOG_API_STOCK);

        return $this->clientConnect
            ->setSaveLog(boolval($configApiLog))
            ->setMock('stock.json', true)
            ->setThrowException(false)
            ->send($requestDTO);
    }
}
