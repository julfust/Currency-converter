<?php

namespace App\Providers;

use App\Models\Currency;
use App\Models\Pair;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Pair::resolveRelationUsing('currencyFrom', function ($pairModel) {
            return $pairModel->belongsTo(Currency::class, 'currency_from_id');
        });

        Pair::resolveRelationUsing('currencyTo', function ($pairModel) {
            return $pairModel->belongsTo(Currency::class, 'currency_to_id');
        });
    }
}
