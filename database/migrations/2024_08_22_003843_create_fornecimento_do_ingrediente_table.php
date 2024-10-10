<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFornecimentoDoIngredienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecimento_do_ingrediente', function (Blueprint $table) {
            $table->id();
            $table->integer('quantidade')->default(0);
            $table->double('valor')->default(0);
            $table->double('valor_total_do_fornecimento')->default(0);
            $table->dateTime('horario_requisicao_ingrediente');
            $table->dateTime('horario_entrega_ingrediente');
            $table->unsignedBigInteger('id_fornecedor');
            $table->foreign('id_fornecedor')->references('id')->on('fornecedors')->onDelete('cascade');
            $table->unsignedBigInteger('id_ingrediente');
            $table->foreign('id_ingrediente')->references('id')->on('ingredientes')->onDelete('cascade');
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
        Schema::dropIfExists('fornecimento_do_ingrediente');
    }
}
