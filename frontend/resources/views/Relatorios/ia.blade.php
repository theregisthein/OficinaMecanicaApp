@extends('layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-info text-white">
            <h3>🤖 Inteligência Artificial - Relatório da Oficina</h3>
        </div>
        <div class="card-body text-center">
            
            <p>Clique abaixo para que a IA analise todo o seu banco de dados e gere insights.</p>

            {{-- 1. Adicionei ID no Form --}}
            <form action="{{ route('relatorio.gerar') }}" method="POST" id="formIA">
                @csrf
                
                {{-- 2. Adicionei ID no Botão --}}
                <button type="submit" class="btn btn-primary btn-lg" id="btnGerar">
                    ⚡ Gerar Relatório com IA
                </button>
            </form>

            <hr>

            {{-- 3. NOVA ÁREA DE LOADING (Começa escondida com d-none) --}}
            <div id="loadingArea" class="d-none my-4">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Carregando...</span>
                </div>
                <h5 class="mt-2 text-muted">Aguarde, a IA está analisando os dados...</h5>
                <small>Isso pode levar alguns segundos.</small>
            </div>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if(isset($relatorio) && $relatorio)
                <div class="alert alert-success text-start">
                    <h4>Análise da IA:</h4>
                    <hr>
                    <div class="relatorio-conteudo">
                        {!! $relatorio !!}
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

{{-- 4. SCRIPT PARA CONTROLAR A TELA --}}
<script>
    document.getElementById('formIA').addEventListener('submit', function() {
        // Pega os elementos
        var btn = document.getElementById('btnGerar');
        var loading = document.getElementById('loadingArea');

        // Esconde o botão para evitar clique duplo e mostra o loading
        btn.classList.add('d-none');
        loading.classList.remove('d-none');
    });
</script>

@endsection