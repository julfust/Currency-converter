<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            "AED" => "United Arab Emirates Dirham",
            "AFN" => "Afghan Afghani",
            "ALL" => "Albanian Lek",
            "AMD" => "Armenian Dram",
            "ANG" => "Netherlands Antillean Guilder",
            "AOA" => "Angolan Kwanza",
            "ARS" => "Argentine Peso"
        ];

        foreach($currencies as $key => $value) {

            Currency::create([
                "code" => $key,
                "name" => $value
            ]);
        }
    }
}
