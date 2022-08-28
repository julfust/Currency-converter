<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'pair_id',
        'number'
    ];

    public function pair() {
        return $this->belongsTo(Pair::class);
    }
}
