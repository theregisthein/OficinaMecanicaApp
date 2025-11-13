<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('itens', ItemController::class);
Route::resource('veiculos', VeiculoController::class);
Route::resource('clientes', PessoaController::class);
Route::resource('ordens', OrdemservicoController::class);