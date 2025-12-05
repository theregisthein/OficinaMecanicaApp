@extends('layout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header bg-info text-white">
            <h3>🤖 Inteligência Artificial - Relatório da Oficina</h3>
        </div>
        <div class="card-body text-center">
            
            <p>Clique abaixo para que a IA analise todo o seu banco de dados e gere insights.</p>

            <form action="{{ route('relatorio.gerar') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary btn-lg">
                    ⚡ Gerar Relatório com IA
                </button>
            </form>

            <hr>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if(isset($relatorio) && $relatorio)
                <div class="alert alert-success text-start">
                    <h4>Análise da IA:</h4>
                    {{-- nl2br converte as quebras de linha da IA em <br> do HTML --}}
                    <p>{!! nl2br(e($relatorio)) !!}</p>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection