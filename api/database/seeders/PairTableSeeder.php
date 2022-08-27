<?php

namespace Database\Seeders;

use App\Models\ConversionRequest;
use App\Models\Currency;
use App\Models\Pair;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PairTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = Currency::all();

        for($i = 0; $i < count($currencies); $i++) {

            foreach($currencies as $currency) {

                if($currency->id !== $currencies[$i]->id) {

                    $pair = Pair::create([
                        "rate" => 0.85,
                        "currency_from_id" => $currencies[$i]->id,
                        "currency_to_id" => $currency->id
                    ]);

                    ConversionRequest::create([
                        "pair_id" => $pair->id,
                        "number" => rand(1, 5000)
                    ]);
                }
    
            }

        }
    }
}
