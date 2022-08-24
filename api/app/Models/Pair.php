<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pair extends Model
{
    use HasFactory;

    // currencyFrom and currencyTo properties provided into app/Providers/AppServiceProvider.php file by defining dynamic relationships
}
