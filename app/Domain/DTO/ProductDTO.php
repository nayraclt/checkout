<?php

namespace App\Domain\DTO;

use Raiadrogasil\Common\DTO\BaseDTO;
use Raiadrogasil\Common\DTO\BaseDTOInterface;

/**
 * @SuppressWarnings(PHPMD)
 *
 * Class ProductDTO
 * @package App\Domain\DTO
 */
class ProductDTO extends BaseDTO implements BaseDTOInterface
{
    private $storeName;

    private $sku;

    private $zipcode;

    private $qty;

    private $valueTo;

    /**
     * @return string
     */
    public function getStoreName()
    {
        return $this->storeName;
    }

    /**
     * @param string $storeName
     */
    public function setStoreName($storeName): void
    {
        $this->storeName = $storeName;
    }

    /**
     * @return int
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param int $sku
     */
    public function setSku($sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return int
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @param int $zipcode
     */
    public function setZipcode($zipcode): void
    {
        $this->zipcode = $zipcode;
    }

    /**
     * @return int
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * @param int $qty
     */
    public function setQty($qty): void
    {
        $this->qty = $qty;
    }

    /**
     * @return float
     */
    public function getValueTo()
    {
        return $this->valueTo;
    }

    /**
     * @param float $valueTo
     */
    public function setValueTo($valueTo): void
    {
        $this->valueTo = $valueTo;
    }

    public function toArray()
    {
        return [
            'storeName' => $this->storeName,
            'sku' => $this->sku,
            'zipcode' => $this->zipcode,
            'qty' => $this->qty,
            'valueTo' => $this->valueTo,
        ];
    }
}
