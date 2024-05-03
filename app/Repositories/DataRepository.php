<?php

namespace App\Repositories;
use App\Contracts\CacheInterface;
use App\Contracts\ExternalApiInterface;
use App\Services\Cache\CacheService;
use App\Services\ExternalApi\ExternalApiService;

class DataRepository {
    protected CacheInterface $cache;
    protected ExternalApiInterface $externalApi;

    public function __construct(ExternalApiService $externalApi, CacheService $cache) {
        $this->cache = $cache;
        $this->externalApi = $externalApi;
    }

    /**
     * @throws \Exception
     */
    public function getData() {
        $cachedData = $this->cache->get();

        if ($cachedData) {
            return $cachedData;
        }

        $data = $this->externalApi->fetchData();

        $this->cache->put($data);

        return $data;
    }
}
