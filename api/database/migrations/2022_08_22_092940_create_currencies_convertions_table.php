<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies_convertions', function (Blueprint $table) {
            $table->increments("id");
            $table->string("currenciesFrom", 100);
            $table->string("currenciesTo", 100);
            $table->float("rate", 9, 3);
            $table->bigInteger("requests_number");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies_convertions');
    }
};
