<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversionRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pair_id',
        'number'
    ];

    /**
     * Define relation between entities
     */
    public function pair() {
        return $this->belongsTo(Pair::class);
    }
}
