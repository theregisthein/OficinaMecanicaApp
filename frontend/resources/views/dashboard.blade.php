@extends('layout')

{{-- ESTILOS ESPECÍFICOS DA HOME (Imagem de Fundo e Centralização) --}}
@push('styles')
<style>
    body.home-layout {
        background-image: url('{{ asset('Imagens/oficina_background.jpg') }}'); 
        background-size: cover; 
        background-position: center;
        
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }

    /* Esconde a barra de navegação padrão apenas na Home para ficar mais limpo */
    body.home-layout main.container > nav {
        display: none !important;
    }

    /* Esconde alertas globais na home para não quebrar o layout */
    body.home-layout main.container > .alert {
        display: none !important;
    }

    body.home-layout main.container {
        padding: 0;
        max-width: 100%; 
    }
</style>
@endpush

{{-- Adiciona a classe no body para ativar o CSS acima --}}
@push('body_attributes')
class="home-layout" 
@endpush


@section('content')

<div class="card p-4 shadow-lg text-center" style="width: 22rem; background-color: rgba(255, 255, 255, 0.95);">
    
    <h3 class="card-title mb-4 fw-bold">Menu Principal</h3>
    
    <div class="d-grid gap-3">
        
        {{-- Botão OS --}}
        <a href="{{ route('ordens.index') }}" class="btn btn-primary btn-lg">
            📋 Gerenciar Ordens de Serviço
        </a>
        
        {{-- Botão Itens --}}
        <a href="{{ route('itens.index') }}" class="btn btn-secondary btn-lg">
            🔧 Gerenciar Itens/Peças
        </a>
        
        {{-- Botão Veículos --}}
        <a href="{{ route('veiculos.index') }}" class="btn btn-info btn-lg text-white">
            🚗 Gerenciar Veículos
        </a>
        
        {{-- Botão Pessoas --}}
        <a href="{{ route('pessoas.index') }}" class="btn btn-success btn-lg">
            👥 Gerenciar Clientes
        </a>

        <hr class="my-1">

        {{-- NOVO: Botão Inteligência Artificial --}}
        <a href="{{ route('relatorio.index') }}" class="btn btn-warning btn-lg fw-bold">
            🤖 Relatórios com IA
        </a>

    </div>
</div>

@endsection