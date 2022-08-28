<?php

namespace App\Http\Controllers;

use App\Http\Resources\PairResource;
use App\Models\Pair;
use Illuminate\Http\Request;

class TestController extends Controller
{

     /**
     * Return message to check if service is functionnal.
     *
     * @return \Illuminate\Http\Response
     */
    public function functionnalService()
    {
        return response()->json(["message" => "Service opérationnel"]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllPairs()
    {
        $pairs = Pair::all();
        
        return response()->json(PairResource::collection($pairs));
    }

    /**
     * Function to convert currencies.
     *
     * @return \Illuminate\Http\Response
     */
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
