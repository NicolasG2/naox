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
            $table->double('quantidade')->default(0); 
            $table->double('valor')->default(0); 
            $table->timestamp('horario_requisicao_pedido')->default(DB::raw('CURRENT_TIMESTAMP')); // Set default
            $table->timestamp('horario_entrega_pedido')->nullable();
            $table->unsignedBigInteger('id_pedido');
            $table->foreign('id_pedido')->references('id')->on('pedidos')->onDelete('cascade');
            $table->unsignedBigInteger('id_produto')->nullable();
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
