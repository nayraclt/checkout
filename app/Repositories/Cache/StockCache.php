<?php

namespace App\Repositories\Cache;

use Raiadrogasil\Common\Repository\Cache\Cache;
use Raiadrogasil\Util\Services\UtilRedis;

/**
 * Class StockCache
 * @package App\Repositories\Cache
 */
class StockCache extends Cache
{
    public const PREFIX_KEY_CACHE_DEFAULT = 'STOCK';

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
     * Recuperar o estoque do cache
     *
     * @param string $storeName
     * @param int $sku
     * @return mixed|null
     */
    public function getStock($storeName, $sku)
    {
        $key = $this->getBuildKey($storeName, $sku);
        return $this->redis->hGetAll($key);
    }

    /**
     * Inclui o estoque no cache
     *
     * @param string $storeName
     * @param int $sku
     * @param mixed $data
     * @return mixed
     */
    public function putStock($storeName, $sku, $data)
    {
        $key = $this->getBuildKey($storeName, $sku);
        return $this->redis->hMSet($key, $data);
    }

    /**
     * Remove o cache baseado na chave passada
     *
     * @param $key
     * @return bool
     */
    public function forgetStock($key)
    {
        $key = $this->getBuildKey($key, "*");
        return $this->redis->clear($key);
    }

    /**
     * Verifica a existencia da chave de cache
     *
     * @param $storeName
     * @param $sku
     * @return bool
     */
    public function hasStock($storeName, $sku)
    {
        $key = $this->getBuildKey($storeName, $sku);
        return $this->redis->exists($key);
    }
}
