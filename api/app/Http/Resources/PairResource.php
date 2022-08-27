<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PairResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "currencyFrom" => [
                "id" => $this->currencyFrom->id,
                "code" => $this->currencyFrom->code,
                "name" => $this->currencyFrom->name,
            ],
            "currencyTo" => [
                "id" => $this->currencyTo->id,
                "code" => $this->currencyTo->code,
                "name" => $this->currencyTo->name,
            ],
            "rate" => $this->rate
        ];
    }
}
