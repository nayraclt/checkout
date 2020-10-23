<?php

namespace App\Repositories\Cache;

use Raiadrogasil\Common\Repository\Cache\Cache;
use Raiadrogasil\Util\Services\UtilRedis;

/**
 * Class ShippingCache
 * @package App\Repositories\Cache
 */
class ShippingCache extends Cache
{
    public const PREFIX_KEY_CACHE_DEFAULT = 'SHIPPING';

    /**
     * @var UtilRedis
     */
    private $redis;

    public function __construct(UtilRedis $redis)
    {
        $this->redis = $redis;
    }

    protected function getBuildKey($storeName, $sku)
    {
        return strtolower(self::PREFIX_KEY_CACHE_DEFAULT . '_' . $storeName . '_' . $sku);
    }

    /**
     * Recuperar os cotação de frete do cache
     *
     * @param string $storeName
     * @param int $sku
     * @param int $zipcode
     * @param int $qty
     * @return mixed|null
     */
    public function getShippingQuote($storeName, $sku, $zipcode, $qty)
    {
        $key = $this->getBuildKey($storeName, $sku, $zipcode, $qty);
        return $this->redis->hGetAll($key);
    }

    /**
     * Inclui cotação de frete no cache
     *
     * @param string $storeName
     * @param int $sku
     * @param int $zipcode
     * @param int $qty
     * @param mixed $data
     * @return mixed
     */
    public function putShippingQuote($storeName, $sku, $zipcode, $qty, $data)
    {
        $key = $this->getBuildKey($storeName, $sku, $zipcode, $qty);
        return $this->redis->hMSet($key, $data);
    }

    /**
     * Remove o cache baseado na chave passada
     *
     * @param $key
     * @return bool
     */
    public function forgetShippingQuote($key)
    {
        $key = $this->getBuildKey($key, "*");
        return $this->redis->clear($key);
    }

    /**
     * Verifica a existencia da chave de cache
     *
     * @param string $storeName
     * @param int $sku
     * @param int $zipcode
     * @param int $qty
     * @return bool
     */
    public function hasShippingQuote($storeName, $sku, $zipcode, $qty)
    {
        $key = $this->getBuildKey($storeName, $sku, $zipcode, $qty);
        return $this->redis->exists($key);
    }
}
