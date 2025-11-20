@extends('layout')

{{-- O layout da Home/Dashboard será sempre o mesmo --}}
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

    body.home-layout main.container > nav {
        display: none !important;
    }

    body.home-layout main.container > .alert {
        display: none !important;
    }

    body.home-layout main.container {
        padding: 0;
        max-width: 100%; 
    }
</style>
@endpush

@push('body_attributes')
class="home-layout" 
@endpush


@section('content')

<div class="card p-4 shadow-lg text-center" style="width: 22rem; background-color: rgba(255, 255, 255, 0.95);">
    
    <h3 class="card-title mb-4">Menu Principal</h3>
    
    <div class="d-grid gap-3">
        
        <a href="{{ route('ordens.index') }}" class="btn btn-primary btn-lg">
            Gerenciar Ordens de Serviço
        </a>
        
        <a href="{{ route('itens.index') }}" class="btn btn-secondary btn-lg">
            Gerenciar Itens/Peças
        </a>
        
        <a href="{{ route('veiculos.index') }}" class="btn btn-info btn-lg">
            Gerenciar Veículos
        </a>
        
        <a href="{{ route('pessoas.index') }}" class="btn btn-success btn-lg">
            Gerenciar Pessoas (Clientes)
        </a>
    </div>
</div>
@endsection