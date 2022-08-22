<?php

namespace Database\Seeders;

use App\Models\CurrenciesConvertion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CurrenciesConvertionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = Http::get('https://exchange-rates.abstractapi.com/v1/historical?api_key=5a15371b09cb42c88f1b3e52c008a93a&base=USD&target=BTC,CAD,ETH,EUR,GBP,CNY,RUB&date=2020-08-31')->body();

        $conversionUsd = json_decode($response);

        foreach($conversionUsd->exchange_rates as $key => $value) {

            $currenciesConvertions = CurrenciesConvertion::create([
                "currenciesFrom" => "USD",
                "currenciesTo" => $key,
                "rate" => $value,
                "requests_number" => 0
            ]);

            $currenciesConvertions->save();
        }
    }
}
