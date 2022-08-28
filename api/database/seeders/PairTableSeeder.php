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

        $pair = Pair::create([
            "rate" => 0.85,
            "currency_from_id" => 1,
            "currency_to_id" => 2
        ]);

        ConversionRequest::create([
            "pair_id" => $pair->id,
            "number" => rand(1, 5000)
        ]);

        $pair = Pair::create([
            "rate" => 0.85,
            "currency_from_id" => 2,
            "currency_to_id" => 3
        ]);

        ConversionRequest::create([
            "pair_id" => $pair->id,
            "number" => rand(1, 5000)
        ]);

        $pair = Pair::create([
            "rate" => 0.85,
            "currency_from_id" => 3,
            "currency_to_id" => 4
        ]);

        ConversionRequest::create([
            "pair_id" => $pair->id,
            "number" => rand(1, 5000)
        ]);

        $pair = Pair::create([
            "rate" => 0.85,
            "currency_from_id" => 4,
            "currency_to_id" => 5
        ]);

        ConversionRequest::create([
            "pair_id" => $pair->id,
            "number" => rand(1, 5000)
        ]);

    }
}
