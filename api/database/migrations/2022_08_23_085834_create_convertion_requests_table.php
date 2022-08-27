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
        Schema::create('conversion_requests', function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("pair_id");
            $table->bigInteger("number");
            $table->timestamps();

            $table->foreign("pair_id")->references("id")->on("pairs")->onDelete("cascade")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversion_requests');
    }
};
