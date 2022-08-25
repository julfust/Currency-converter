<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Pair;
use Illuminate\Http\Request;

class PairController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pairs = Pair::all();
        $formatedPairs = [];

        foreach($pairs as $pair) {

            array_push(
                $formatedPairs, 
                [
                    "id" => $pair->id,
                    "currencyFrom" => [
                        "code" => $pair->currencyFrom->code,
                        "name" => $pair->currencyFrom->name,
                    ],
                    "currencyTo" => [
                        "code" => $pair->currencyTo->code,
                        "name" => $pair->currencyTo->name,
                    ],
                    "rate" => $pair->rate
                ]
            );
        };
        
        return response()->json($formatedPairs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $currencyFrom = Currency::where("code", $request->currencyFrom['code'])->get()->first();
        $currencyTo = Currency::where("code", $request->currencyTo['code'])->get()->first();

        if(empty($currencyFrom)) {
            $currencyFrom = Currency::create([
                "code" => $request->currencyFrom['code'],
                "name" => $request->currencyFrom['name']
            ]);
        }

        if(empty($currencyTo)) {
            $currencyTo = Currency::create([
                "code" => $request->currencyTo['code'],
                "name" => $request->currencyTo['name']
            ]);
        }

        $pair = Pair::create([
            "currency_from_id" => $currencyFrom->id,
            "currency_to_id" => $currencyTo->id,
            "rate" => $request->rate
        ]);

        return response()->json(
            [
                "id" => $pair->id,
                "currencyFrom" => [
                    "code" => $pair->currencyFrom->code,
                    "name" => $pair->currencyFrom->name,
                ],
                "currencyTo" => [
                    "code" => $pair->currencyTo->code,
                    "name" => $pair->currencyTo->name,
                ],
                "rate" => $pair->rate
            ], 
            201
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $pair)
    {
        $pair->update([
            "currenciesFrom" => $request->currenciesFrom,
            "currenciesTo" => $request->currenciesTo,
            "rate" => $request->rate,
        ]);

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($pair)
    {
        $pair->delete();

        return response()->json();
    }
}
