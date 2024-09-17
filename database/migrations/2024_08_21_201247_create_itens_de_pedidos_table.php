<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItensDePedidosTable extends Migration
{
    public function up()
    {
        Schema::create('itens_de_pedidos', function (Blueprint $table) {
            $table->id();
            $table->double('quantidade_do_item');
            $table->double('valor_do_item');
            $table->dateTime('horario_requisicao_pedido');
            $table->dateTime('horario_entrega_pedido');
            $table->unsignedBigInteger('id_pedido');
            $table->foreign('id_pedido')->references('id')->on('pedidos')->onDelete('cascade');
            $table->unsignedBigInteger('id_produto');
            $table->foreign('id_produto')->references('id')->on('produtos')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('itens_de_pedidos');
    }
}
