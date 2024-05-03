<?php

declare(strict_types=1);

use App\Http\Controllers\API\V1\CurrencyController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function(){
    Route::get('get-exchange-rates', [CurrencyController::class, 'getExchangeRates']);
});


