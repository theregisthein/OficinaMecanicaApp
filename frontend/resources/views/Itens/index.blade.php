@extends('layout')

@section('content')
<div class="container">
    
    <div class="card mb-4">
        <div class="card-header">
            <h3>Cadastrar Novo Item</h3>
        </div>
        <div class="card-body">

            <form action="{{ route('itens.store') }}" method="POST">
                
                {{-- @csrf é para segurança em formulários Laravel --}}
                @csrf 

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nome" class="form-label">Nome do Item</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="valor" class="form-label">Valor (R$)</label>
                    <input type="number" class="form-control" id="valor" name="valor" step="0.01" min="0" required>
                </div>

                <hr>
                <button type="submit" class="btn btn-primary">Salvar Item</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Itens Cadastrados</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Valor</th>
                        <th scope="col" style="width: 150px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- O Controller PHP passou a variável $itens para cá --}}
                    @foreach ($itens as $item)
                        <tr>
                            {{-- IMPORTANTE: É Usado $item['id'] (array) 
                                porque os dados vêm de um JSON da sua API Java,
                                e não de um Objeto Eloquent. Pode acontecer erro --}}

                            <td>{{ $item['id'] }}</td>
                            <td>{{ $item['nome'] }}</td>
                            <td>{{ $item['marca'] }}</td>
                            <td>R$ {{ number_format($item['valor'], 2, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('itens.edit', $item['id']) }}" class="btn btn-warning btn-sm">
                                    Editar
                                </a>

                                <form action="{{ route('itens.destroy', $item['id']) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir?')">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection