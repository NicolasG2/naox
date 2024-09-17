<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Seed para a tabela de usuários
        DB::table('users')->insert([
            [
                'nome' => 'Admin User',
                'nome_de_usuario' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'tipo_acesso' => 'dono',
                'telefone' => '123456789',
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Regular User',
                'nome_de_usuario' => 'user',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'tipo_acesso' => 'gerente',
                'telefone' => '987654321',
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => 'Carlos Souza',
                'nome_de_usuario' => 'carlos.souza',
                'email' => 'carlos@example.com',
                'password' => Hash::make('123456'),
                'tipo_acesso' => 'funcionario',
                'telefone' => '999999999',
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed para a tabela de categorias de ingredientes
        DB::table('categoria_ingredientes')->insert([
            ['nome' => 'Frutas', 'area' => 'Cozinha', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Verduras', 'area' => 'Cozinha', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Laticínios', 'area' => 'Geladeira', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Seed para a tabela de categorias de produtos
        DB::table('categoria_produtos')->insert([
            ['nome' => 'Bebidas', 'area' => 'Bar', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Comidas', 'area' => 'Cozinha', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Sobremesas', 'area' => 'Cozinha', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Seed para a tabela de fornecedores
        DB::table('fornecedors')->insert([
            ['nome' => 'Fornecedor 1', 'telefone' => '111111111', 'documento' => '123456789', 'ativo' => 1, 'email' => 'fornecedor1@example.com', 'endereco' => 'Rua A, 123', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Fornecedor 2', 'telefone' => '222222222', 'documento' => '987654321', 'ativo' => 1, 'email' => 'fornecedor2@example.com', 'endereco' => 'Rua B, 456', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Fornecedor 3', 'telefone' => '333333333', 'documento' => '112233445', 'ativo' => 1, 'email' => 'fornecedor3@example.com', 'endereco' => 'Rua C, 789', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Seed para a tabela de ingredientes
        DB::table('ingredientes')->insert([
            ['nome' => 'Tomate', 'unidade' => 'kg', 'quantidade' => 50, 'custo' => 2.50, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Batata', 'unidade' => 'kg', 'quantidade' => 100, 'custo' => 1.80, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Leite', 'unidade' => 'L', 'quantidade' => 200, 'custo' => 3.20, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Farinha', 'unidade' => 'kg', 'quantidade' => 150, 'custo' => 4.00, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Seed para a tabela de produtos
        DB::table('produtos')->insert([
            ['nome' => 'Coca-Cola', 'preco' => 5.00, 'ativo' => true, 'quantidade' => 200, 'descricao' => 'Refrigerante de Cola', 'custo' => 2.00, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Hamburguer', 'preco' => 12.00, 'ativo' => true, 'quantidade' => 50, 'descricao' => 'Hamburguer de Carne', 'custo' => 5.50, 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Sorvete', 'preco' => 8.00, 'ativo' => true, 'quantidade' => 30, 'descricao' => 'Sorvete de Baunilha', 'custo' => 3.50, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Seed para a tabela de receitas
        DB::table('receitas')->insert([
            ['quantidade_do_ingrediente_no_produto' => '200g', 'id_produto' => 2, 'id_ingrediente' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['quantidade_do_ingrediente_no_produto' => '100g', 'id_produto' => 2, 'id_ingrediente' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Seed para a tabela de clientes
        DB::table('clientes')->insert([
            ['nome' => 'João Silva', 'telefone' => '999988887', 'desconto' => 10, 'cpf' => '12345678901', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Maria Oliveira', 'telefone' => '888877776', 'desconto' => 5, 'cpf' => '98765432101', 'created_at' => now(), 'updated_at' => now()],
            ['nome' => 'Ana Santos', 'telefone' => '777766665', 'desconto' => 15, 'cpf' => '56473829101', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Seed para a tabela de mesas
        DB::table('mesas')->insert([
            ['numero' => 1, 'capacidade' => 4, 'formato' => 'Redonda', 'tamanho' => 'Grande', 'created_at' => now(), 'updated_at' => now()],
            ['numero' => 2, 'capacidade' => 2, 'formato' => 'Quadrada', 'tamanho' => 'Média', 'created_at' => now(), 'updated_at' => now()],
            ['numero' => 3, 'capacidade' => 6, 'formato' => 'Retangular', 'tamanho' => 'Grande', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Seed para a tabela de pedidos
        DB::table('pedidos')->insert([
            ['num_pessoas' => 2, 'valor_total_pedido' => 25.00, 'id_mesa' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['num_pessoas' => 4, 'valor_total_pedido' => 50.00, 'id_mesa' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['num_pessoas' => 6, 'valor_total_pedido' => 100.00, 'id_mesa' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Seed para a tabela de itens de pedidos
        DB::table('itens_de_pedidos')->insert([
            ['quantidade_do_item' => 2, 'valor_do_item' => 10.00, 'horario_requisicao_pedido' => now(), 'horario_entrega_pedido' => now(), 'id_pedido' => 1, 'id_produto' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['quantidade_do_item' => 1, 'valor_do_item' => 12.00, 'horario_requisicao_pedido' => now(), 'horario_entrega_pedido' => now(), 'id_pedido' => 1, 'id_produto' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['quantidade_do_item' => 1, 'valor_do_item' => 8.00, 'horario_requisicao_pedido' => now(), 'horario_entrega_pedido' => now(), 'id_pedido' => 2, 'id_produto' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Seed para tabela de produto_muitas_categorias
        DB::table('produto_muitas_categorias')->insert([
            ['id_produto' => 1, 'id_categoria_produto' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_produto' => 2, 'id_categoria_produto' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Seed para tabela de ingrediente_muitas_categorias
        DB::table('ingrediente_muitas_categorias')->insert([
            ['id_ingrediente' => 1, 'id_categoria_ingrediente' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_ingrediente' => 2, 'id_categoria_ingrediente' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Seed para tabela de pedido_dos_clientes
        DB::table('pedido_dos_clientes')->insert([
            ['id_pedido' => 1, 'id_cliente' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_pedido' => 2, 'id_cliente' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Seed para tabela de fornecimento_do_produto
        DB::table('fornecimento_do_produto')->insert([
            ['id_fornecedor' => 1, 'id_produto' => 1, 'created_at' => now(), 'horario_requisicao_produto' => now(), 'horario_entrega_produto' => now(), 'updated_at' => now()],
            ['id_fornecedor' => 2, 'id_produto' => 2, 'created_at' => now(), 'horario_requisicao_produto' => now(), 'horario_entrega_produto' => now(), 'updated_at' => now()],
        ]);

        // Seed para tabela de fornecimento_do_ingrediente
        DB::table('fornecimento_do_ingrediente')->insert([
            ['id_fornecedor' => 3, 'id_ingrediente' => 1, 'created_at' => now(), 'horario_requisicao_ingrediente' => now(), 'horario_entrega_ingrediente' => now(), 'updated_at' => now()],
            ['id_fornecedor' => 1, 'id_ingrediente' => 2, 'created_at' => now(), 'horario_requisicao_ingrediente' => now(), 'horario_entrega_ingrediente' => now(), 'updated_at' => now()],
        ]);

        // Seed para tabela de atendimento_feito_pelo_funcionario
        DB::table('atendimento_feito_pelo_funcionario')->insert([
            ['id_pedido' => 1, 'id_user' => 1, 'created_at' => now(), 'horario_abertura_atendimento' => now(), 'horario_fechamento_atendimento' => now(),'updated_at' => now()],
            ['id_pedido' => 2, 'id_user' => 2, 'created_at' => now(), 'horario_abertura_atendimento' => now(), 'horario_fechamento_atendimento' => now(), 'updated_at' => now()],
        ]);
    }
}
