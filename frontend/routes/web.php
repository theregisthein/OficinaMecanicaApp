<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\PessoaController;


Route::get('/', function () {
    return view('welcome');
});

Route::resource('itens', ItemController::class);
Route::patch('itens/{id}/toggle-status', [ItemController::class, 'toggleStatus'])->name('itens.toggleStatus'); // rota para alternar o status caso tiver
Route::resource('veiculos', VeiculoController::class);
Route::patch('veiculos/{id}/toggle-status', [VeiculoController::class, 'toggleStatus'])->name('veiculos.toggleStatus');
Route::resource('pessoas', PessoaController::class);
Route::resource('ordens', OrdemservicoController::class);