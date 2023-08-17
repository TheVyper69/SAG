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
        Schema::create('paradas_rela', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_parada')->nullable();
            $table->unsignedBigInteger('id_parada_anterior')->nullable();
            $table->string('tiempo');
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
        Schema::dropIfExists('paradas_rela');
    }
};
