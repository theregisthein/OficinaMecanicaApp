@extends('layout')

@section('content')
<div class="container">
    <div class="card mb-4">
        <div class="card-header bg-warning">
            <h3>Editar Veículo: {{ $veiculo['marca'] ?? '' }} {{ $veiculo['modelo'] ?? '' }} (Placa: {{ $veiculo['placa'] }})</h3>
        </div>
        <div class="card-body">

            <form action="{{ route('veiculos.update', $veiculo['id']) }}" method="POST">
                @csrf
                @method('PUT') {{-- Essencial para o Laravel entender que é uma atualização --}}

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="marca" class="form-label">Marca</label>
                        <input type="text" class="form-control" id="marca" name="marca" 
                               value="{{ $veiculo['marca'] ?? '' }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="modelo" class="form-label">Modelo</label>
                        <input type="text" class="form-control" id="modelo" name="modelo" 
                               value="{{ $veiculo['modelo'] ?? '' }}" required>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="placa" class="form-label">Placa</label>
                        <input type="text" class="form-control" id="placa" name="placa" 
                               value="{{ $veiculo['placa'] ?? '' }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="ano" class="form-label">Ano</label>
                        <input type="number" class="form-control" id="ano" name="ano" 
                               min="1950" max="{{ date('Y') + 1 }}" 
                               value="{{ $veiculo['ano'] ?? '' }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="cor" class="form-label">Cor</label>
                        <input type="text" class="form-control" id="cor" name="cor"
                               value="{{ $veiculo['cor'] ?? '' }}">
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('veiculos.index') }}" class="btn btn-secondary">Cancelar</a>
                    
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection