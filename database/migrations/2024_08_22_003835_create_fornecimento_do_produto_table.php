<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFornecimentoDoProdutoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecimento_do_produto', function (Blueprint $table) {
            $table->id();
            $table->integer('quantidade_do_produto')->default(0);
            $table->double('valor_do_produto')->default(0);
            $table->double('valor_total_do_fornecimento')->default(0);
            $table->dateTime('horario_requisicao_produto');
            $table->dateTime('horario_entrega_produto');
            $table->unsignedBigInteger('id_fornecedor');
            $table->foreign('id_fornecedor')->references('id')->on('fornecedors')->onDelete('cascade');
            $table->unsignedBigInteger('id_produto');
            $table->foreign('id_produto')->references('id')->on('produtos')->onDelete('cascade');
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
        Schema::dropIfExists('fornecimento_do_produto');
    }
}
