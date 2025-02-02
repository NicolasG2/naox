<?php

use Illuminate\Support\Facades\Route;

// Home Routes
Route::get('/', 'PedidoController@home')->name('home');
Route::get('/home', 'PedidoController@home')->name('home');

// Settings
Route::get('/settings', 'SettingsController@index')->name('settings.index');
Route::get('/settings/settings', function () {
    return view('settings.settings');
})->name('settings.settings');

Route::prefix('settings')->group(function () {
    Route::resource('mesas', 'MesaController');
});

Route::get('/settings/mesas/check-number/{numero}', 'MesaController@checkNumber');

// Resources
Route::resource('estoques', 'EstoqueController');
Route::resource('categorias', 'CategoriaController');
Route::resource('clientes', 'ClienteController');
Route::resource('produtos', 'ProdutoController');
Route::resource('ingredientes', 'IngredienteController');
Route::resource('fornecedores', 'FornecedorController');
Route::resource('users', 'UserController');

// Estoque Routes
Route::get('/estoque', 'EstoqueController@index')->name('estoque.index');
Route::put('/estoque/produto/{id}', 'EstoqueController@updateProduto')->name('estoque.updateProduto');
Route::put('/estoque/ingrediente/{id}', 'EstoqueController@updateIngrediente')->name('estoque.updateIngrediente');

// Pedido Routes
Route::post('/pedidos', 'PedidoController@store')->name('pedidos.store');
Route::post('/pedidos/{pedido}', 'PedidoController@adicionarProduto')->name('pedidos.adicionarProduto');
Route::get('/pedido/detalhes/{id_mesa}', 'PedidoController@show');
Route::post('/pedidos/{pedido}/finalizar', 'PedidoController@finalizarPedido')->name('pedidos.finalizarPedido');

