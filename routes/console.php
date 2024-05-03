<?php

use App\Jobs\FetchExchangeRatesJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Schedule::job(FetchExchangeRatesJob::class)
    ->everyMinute()
    ->onFailure(function () {
        Log::error("Fail in execution of scheduled task");
    })
    ->withoutOverlapping();
