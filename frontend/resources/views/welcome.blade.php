@extends('layout')

@push('styles')
<style>
    body.login-page {
        background-image: url('{{ asset('Imagens/oficina_background.jpg') }}'); 
        background-size: cover; 
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        margin: 0; 
    }
    /* Esconde a nav na tela de login */
    body.login-page main.container > nav { display: none !important; }
    body.login-page main.container { padding: 0; max-width: 100%; }
</style>
@endpush

@push('body_attributes')
class="login-page" 
@endpush

@section('content')
<div class="card shadow-lg p-4" style="width: 22rem; background-color: rgba(255, 255, 255, 0.95);">
    <div class="text-center mb-4">
        <h3>Oficina Mecânica</h3>
        <p class="text-muted">Acesso Restrito</p>
    </div>

    <form action="{{ route('login.submit') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" required placeholder="seu@email.com">
        </div>

        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" required placeholder="******">
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
        </div>
    </form>
</div>
@endsection