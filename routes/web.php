<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'PedidoController@home')->name('home');
Route::get('/home', 'PedidoController@home')->name('home');

Route::get('/settings', 'SettingsController@index')->name('settings.index');
Route::get('/settings/settings', function () {
    return view('settings.settings');
})->name('settings.settings');

Route::prefix('settings')->group(function () {
    Route::resource('mesas', 'MesaController');
});

Route::resource('pedidos', 'PedidoController');
Route::resource('vendas', 'VendaController');
Route::resource('despesas', 'DespesaController');
Route::resource('estoques', 'EstoqueController');
Route::resource('categorias', 'CategoriaController');
Route::resource('clientes', 'ClienteController');
Route::resource('produtos', 'ProdutoController');
Route::resource('ingredientes', 'IngredienteController');
Route::resource('fornecedores', 'FornecedorController');
Route::resource('users', 'UserController');

Route::get('/estoque', 'EstoqueController@index')->name('estoque.index');
Route::post('/estoque/update', 'EstoqueController@update')->name('estoque.update');
