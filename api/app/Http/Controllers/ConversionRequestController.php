<?php

namespace App\Http\Controllers;

use App\Http\Resources\PairResource;
use App\Models\ConversionRequest;
use Illuminate\Http\Request;

class ConversionRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requests = ConversionRequest::all();
        $formatedData = [];

        foreach($requests->all() as $request) {

            array_push(
                $formatedData,
                [
                    "id" => $request->id,
                    "number" => $request->number,
                    "pair" => new PairResource($request->pair)
                ]
            );
        };
        
        return response()->json($formatedData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
