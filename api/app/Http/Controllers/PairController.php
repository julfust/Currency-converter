<?php

namespace App\Http\Controllers;

use App\Http\Resources\PairResource;
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
        
        return response()->json(PairResource::collection($pairs));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $pairRequest)
    {
        if($pairRequest->currencyFromId === $pairRequest->currencyToId) {

            return response()->json([
                "error" => "Impossible de créer une paire de devises identiques"
            ], 409);
        }

        if(!empty(Pair::where('currency_from_id', $pairRequest->currencyFromId)->where("currency_to_id", $pairRequest->currencyToId)->first())) {

            return response()->json([
                "error" => "La paire de conversion existe déjà"
            ], 409);
        }

        $pair = Pair::create([
            "currency_from_id" => $pairRequest->currencyFromId,
            "currency_to_id" => $pairRequest->currencyToId,
            "rate" => $pairRequest->rate
        ]);
        
        return response()->json(new PairResource($pair), 201);
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
    public function update(Request $pairRequest, $id)
    {

        if($pairRequest->currencyFromId === $pairRequest->currencyToId) {

            return response()->json([
                "error" => "Impossible de créer une paire de devises identiques"
            ], 409);
        }

        if(!empty(Pair::where('currency_from_id', $pairRequest->currencyFromId)->where("currency_to_id", $pairRequest->currencyToId)->first())) {

            return response()->json([
                "error" => "La paire de conversion existe déjà"
            ], 409);
        }
            
        $pair = Pair::find($id);

        $pair->update([
            "currency_from_id" => $pairRequest->currencyFromId,
            "currency_to_id" => $pairRequest->currencyToId,
            "rate" => $pairRequest->rate
        ]);

        return response()->json(new PairResource($pair), 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pair = Pair::find($id);

        $pair->delete();

        return response()->json([ "deleted" => "true" ]);
    }
}
