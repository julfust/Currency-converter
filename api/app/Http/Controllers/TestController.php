<?php

namespace App\Http\Controllers;

use App\Http\Resources\PairResource;
use App\Models\Pair;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function functionnalService()
    {
        return response()->json(["message" => "Service opérationnel"]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  http://localhost:8000/api/testConversion?$currencyFromId=2&$currencyToId=3&amount=500
    public function getAllPairs()
    {
        $pairs = Pair::all();
        
        return response()->json(PairResource::collection($pairs));
    }

    public function convertCurrencies(Request $conversionRequest)
    {

        $conversionPair = Pair::where('currency_from_id', $conversionRequest->currencyFromId)->where("currency_to_id", $conversionRequest->currencyToId)->first();

        if(!empty($conversionPair)) {

            $conversionRequest->amount *= $conversionPair->rate;

            return response()->json(["resultat" => $conversionRequest->amount]);
        }

        $conversionPair = Pair::where('currency_from_id', $conversionRequest->currencyToId)->where("currency_to_id", $conversionRequest->currencyFromId)->first();

        if(!empty($conversionPair)) {

            $conversionRequest->amount /= $conversionPair->rate;

            return response()->json(["resultat" => $conversionRequest->amount]);
        }

        return response()->json([
            "error" => "La paire de conversion sélectionnée n'existe pas"
        ], 404);
    }
}
