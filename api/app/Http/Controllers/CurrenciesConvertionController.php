<?php

namespace App\Http\Controllers;

use App\Models\CurrenciesConvertion;
use Illuminate\Http\Request;

class CurrenciesConvertionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currenciesConvertion = CurrenciesConvertion::all();

        return response()->json($currenciesConvertion);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currenciesConvertion = CurrenciesConvertion::create([
            "currenciesFrom" => $request->currenciesFrom,
            "currenciesTo" => $request->currenciesTo,
            "rate" => $request->rate,
            "requests_number" => 0,
        ]);

        return response()->json($currenciesConvertion, 201);
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
    public function update(Request $request, $currenciesConvertion)
    {
        $currenciesConvertion->update([
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
    public function destroy($currenciesConvertion)
    {
        $currenciesConvertion->delete();

        return response()->json();
    }
}
