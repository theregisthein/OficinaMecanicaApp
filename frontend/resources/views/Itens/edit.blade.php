@extends('layout')

@section('content')
<div class="container">
    <div class="card mb-4">
        <div class="card-header bg-warning">
            <h3>Editar Item: {{ $item['nome'] }}</h3>
        </div>
        <div class="card-body">

            <form action="{{ route('itens.update', $item['id']) }}" method="POST">
                
                @csrf
                @method('PUT') {{--  para o laravel entender que é edição --}}

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nome" class="form-label">Nome do Item</label>
                        {{-- VALUE: Preenche o campo com o dado que veio do crud --}}
                        <input type="text" 
                               class="form-control" 
                               id="nome" 
                               name="nome" 
                               value="{{ $item['nome'] }}" 
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" 
                               class="form-control" 
                               id="marca" 
                               name="marca" 
                               value="{{ $item['marca'] }}">
                    </div>
                </div>

                

                <div class="col-md-4 mb-3">
                    <label for="preco" class="form-label">Preco (R$)</label>
                    <input type="number" 
                           class="form-control" 
                           id="preco" 
                           name="preco" 
                           step="0.01" 
                           min="0" 
                           value="{{ $item['preco'] }}" 
                           required>
                </div>

                <hr>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('itens.index') }}" class="btn btn-secondary">Cancelar</a>
                    
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection