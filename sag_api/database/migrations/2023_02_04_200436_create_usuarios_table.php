<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_rol')->nullable();
            $table->string('nombre');
            $table->string('email');
            $table->string('telefono', 20);
            $table->unsignedBigInteger('id_empresa')->nullable();
            $table->string('ruta');
            $table->string('password');
            $table->string('estado');
            $table->timestamps();

            $table->foreign('id_rol')->references('id')->on('rols');
            $table->foreign('id_empresa')->references('id')->on('empresas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
};
