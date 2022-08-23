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
        Schema::create('pairs', function (Blueprint $table) {
            $table->increments("id");
            $table->float("rate", 9, 3);
            $table->unsignedInteger("currency_from_id");
            $table->unsignedInteger("currency_to_id");
            $table->timestamps();

            $table->foreign("currency_from_id")->references("id")->on("currencies")->onDelete("cascade");
            $table->foreign("currency_to_id")->references("id")->on("currencies")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pairs');
    }
};
