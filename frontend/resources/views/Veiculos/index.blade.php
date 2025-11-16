@extends('layout')

@section('content')
<div class="container">
    
    <div class="card mb-4">
        <div class="card-header">
            <h3>Cadastrar Novo Veículo</h3>
        </div>
        <div class="card-body">

            <form action="{{ route('veiculos.store') }}" method="POST">
                @csrf 

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="modelo" class="form-label">Modelo</label>
                        <input type="text" class="form-control" id="modelo" name="modelo" required>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="placa" class="form-label">Placa</label>
                        <input type="text" class="form-control" id="placa" name="placa" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="ano" class="form-label">Ano</label>
                        <input type="number" class="form-control" id="ano" name="ano" min="1950" max="{{ date('Y') + 1 }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="cor" class="form-label">Cor</label>
                        <input type="text" class="form-control" id="cor" name="cor">
                    </div>
                </div>

                <hr>
                <button type="submit" class="btn btn-primary">Salvar Veículo</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Veículos Cadastrados</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Modelo</th>
                        <th scope="col">Placa</th>
                        <th scope="col">Ano</th>
                        <th scope="col">Cor</th>
                        <th scope="col" style="width: 200px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($veiculos as $veiculo)
                        <tr>
                            <td>{{ $veiculo['id'] }}</td>
                            <td>{{ $veiculo['marca'] }}</td>
                            <td>{{ $veiculo['modelo'] }}</td>
                            <td>{{ $veiculo['placa'] }}</td>
                            <td>{{ $veiculo['ano'] }}</td>
                            <td>{{ $veiculo['cor'] }}</td>
                          
                            <td>
                                <a href="{{ route('veiculos.edit', $veiculo['id']) }}" class="btn btn-warning btn-sm">
                                    Editar
                                </a>
                            
                                <form action="{{ route('veiculos.destroy', $veiculo['id']) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza? Essa ação não pode ser desfeita.')">
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