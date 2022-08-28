<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pair extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'currency_from_id',
        'currency_to_id',
        'rate'
    ];

    /**
     * Define relation between entities
     */
    public function request() {
        return $this->hasOne(Request::class);
    }

    // currencyFrom and currencyTo properties provided into app/Providers/AppServiceProvider.php file by defining dynamic relationships
}
