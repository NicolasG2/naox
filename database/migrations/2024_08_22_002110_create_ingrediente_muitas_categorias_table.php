<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredienteMuitasCategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingrediente_muitas_categorias', function (Blueprint $table) {
            $table->id();    
            $table->unsignedBigInteger('id_ingrediente');
            $table->foreign('id_ingrediente')->references('id')->on('ingredientes')->onDelete('cascade');
            $table->unsignedBigInteger('id_categoria_ingrediente');
            $table->foreign('id_categoria_ingrediente')->references('id')->on('categoria_ingredientes')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('ingrediente_muitas_categorias');
    }
}
