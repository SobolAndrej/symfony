<?php

namespace DomainBundle\Service;

use Aequasi\Bundle\CacheBundle\Service\CacheService;

/**
 * Class MemcachedService
 *
 * @package DomainBundle\Service
 */
class MemcachedService
{

    const SERVICE = 'domain.service.memcached';

    /**
     * @var CacheService
     */
    protected $cacheInstance;

    /**
     * @param CacheService $cacheInstance
     */
    public function __construct(CacheService $cacheInstance)
    {
        $this->cacheInstance = $cacheInstance;
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->cacheInstance->fetch($id);
    }

    /**
     * @param string $id
     * @param $data
     * @return mixed
     */
    public function set($id, $data)
    {
        return $this->cacheInstance->cache($id, $data, CacheService::SIXTY_SECOND);
    }

    /**
     * @param $id
     * @return bool
     */
    public function remove($id)
    {
        return $this->cacheInstance->delete($id);
    }
}
