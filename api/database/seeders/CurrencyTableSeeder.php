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
            "ARS" => "Argentine Peso",
            "AUD" => "Australian Dollar",
            "AWG" => "Aruban Florin",
            "AZN" => "Azerbaijani Manat",
            "BAM" => "Bosnia-Herzegovina Convertible Mark",
            "BBD" => "Barbadian Dollar",
            "BDT" => "Bangladeshi Taka",
            "BGN" => "Bulgarian Lev",
            "BHD" => "Bahraini Dinar",
            "BIF" => "Burundian Franc",
            "BMD" => "Bermudan Dollar",
            "BND" => "Brunei Dollar",
            "BOB" => "Bolivian Boliviano",
            "BRL" => "Brazilian Real",
            "BSD" => "Bahamian Dollar",
            "BTC" => "Bitcoin",
            "BTN" => "Bhutanese Ngultrum",
            "BWP" => "Botswanan Pula",
            "BYN" => "New Belarusian Ruble",
            "BYR" => "Belarusian Ruble",
            "BZD" => "Belize Dollar",
            "CAD" => "Canadian Dollar",
            "CDF" => "Congolese Franc",
            "CHF" => "Swiss Franc",
            "CLF" => "Chilean Unit of Account (UF)",
            "CLP" => "Chilean Peso",
            "CNY" => "Chinese Yuan",
            "COP" => "Colombian Peso",
            "CRC" => "Costa Rican Col\u00f3n",
            "CUC" => "Cuban Convertible Peso",
            "CUP" => "Cuban Peso",
            "CVE" => "Cape Verdean Escudo",
            "CZK" => "Czech Republic Koruna",
            "DJF" => "Djiboutian Franc",
            "DKK" => "Danish Krone",
            "DOP" => "Dominican Peso",
            "DZD" => "Algerian Dinar",
            "EGP" => "Egyptian Pound",
            "ERN" => "Eritrean Nakfa",
            "ETB" => "Ethiopian Birr",
            "EUR" => "Euro"
        ];

        foreach($currencies as $key => $value) {

            Currency::create([
                "code" => $key,
                "name" => $value
            ]);
        }
    }
}
