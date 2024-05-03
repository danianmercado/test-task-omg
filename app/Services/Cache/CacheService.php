<?php
namespace App\Services\Cache;

use App\Contracts\CacheInterface;
use Illuminate\Support\Facades\Cache;

class CacheService implements CacheInterface
{
    public function get()
    {
        return Cache::get(env('CACHE_KEY'));
    }

    public function put($value): void
    {
        Cache::put(env('CACHE_KEY'), $value, now()->addHours(24));
    }
}
