<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRutasTable extends Migration
{
    
   
    public function up()
    {
        Schema::create('rutas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_empresa')->nullable();
            $table->string('nombre');
            $table->timestamps();
            
            $table->foreign('id_empresa')->references('id')->on('empresas');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rutas');
    }
};
