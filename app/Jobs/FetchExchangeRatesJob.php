<?php

namespace App\Jobs;

use App\Services\Cache\CacheService;
use App\Services\ExternalApi\ExternalApiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchExchangeRatesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 2;

    protected ExternalApiService $externalApi;
    protected CacheService $cache;

    public function __construct(ExternalApiService $externalApi, CacheService $cache)
    {
        $this->externalApi = $externalApi;
        $this->cache = $cache;
        $this->tries = env('MAX_RETRIES');
    }

    /**
     * @throws \Exception
     */
    public function handle(): void
    {
        $exchangeRates = $this->externalApi->fetchData();
        $this->cache->put($exchangeRates);
    }
}
