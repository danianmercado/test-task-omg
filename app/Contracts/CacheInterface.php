<?php

namespace App\Contracts;

interface CacheInterface {
    public function get();
    public function put($value);
}
