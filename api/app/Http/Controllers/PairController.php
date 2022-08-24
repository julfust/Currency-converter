<?php

namespace App\Http\Controllers;

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
        $pair = Pair::create([
            "currenciesFrom" => $request->currenciesFrom,
            "currenciesTo" => $request->currenciesTo,
            "rate" => $request->rate,
            "requests_number" => 0,
        ]);

        return response()->json($pair, 201);
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
