<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\Ordemservicocontroller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::resource('itens', ItemController::class);
Route::patch('itens/{id}/toggle-status', [ItemController::class, 'toggleStatus'])->name('itens.toggleStatus'); // rota para alternar o status caso tiver
Route::resource('veiculos', VeiculoController::class);
Route::patch('veiculos/{id}/toggle-status', [VeiculoController::class, 'toggleStatus'])->name('veiculos.toggleStatus');
Route::resource('pessoas', PessoaController::class);
Route::resource('ordens', OrdemservicoController::class);


// ROTAS DE AUTENTICAÇÃO Não Protegidas
Route::get('/', [LoginController::class, 'showLoginForm'])->name('home');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


// ROTAS PROTEGIDAS 
Route::middleware(['auth.custom'])->group(function () {
    
    // Rota do Dashboard menu principal
Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');

    // Rota da OS
    Route::resource('ordens', OrdemservicoController::class);
    
    // Rota de Pessoas 
    Route::resource('pessoas', PessoaController::class);
    
    // Rota de Veículos
    Route::resource('veiculos', VeiculoController::class);
    
    // Rota de Itens
    Route::resource('itens', ItemController::class);
});