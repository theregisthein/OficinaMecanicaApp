@extends('layout')

@section('content')
<div class="container">
    
    <div class="card mb-4">
        <div class="card-header">
            <h3>Cadastrar Nova Pessoa</h3>
        </div>
        <div class="card-body">

            <form action="{{ route('pessoas.store') }}" method="POST">
                @csrf 

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" minlength="9" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="endereco" class="form-label">Endereço</label>
                    <input type="text" class="form-control" id="endereco" name="endereco">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cpfcnpj" class="form-label">CPF/CNPJ</label>
                        <input type="text" class="form-control" id="cpfcnpj" name="cpfcnpj" required minlength="11" maxlength="14" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tipo</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo" id="tipoFisica" value="F" checked>
                            <label class="form-check-label" for="tipoFisica">
                                Pessoa Física
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo" id="tipoJuridica" value="J">
                            <label class="form-check-label" for="tipoJuridica">
                                Pessoa Jurídica
                            </label>
                        </div>
                    </div>
                </div>

                <hr>
                <button type="submit" class="btn btn-primary">Salvar Pessoa</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Pessoas Cadastradas</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">CPF/CNPJ</th>
                        <th scope="col">Tipo</th>
                        <th scope="col" style="width: 150px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pessoas as $pessoa)
                        <tr>
                            <td>{{ $pessoa['id'] }}</td>
                            <td>{{ $pessoa['nome'] }}</td>
                            <td>{{ $pessoa['telefone'] }}</td>
                            <td>{{ $pessoa['cpfcnpj'] }}</td>
                            
                            <td>
                                @if($pessoa['tipo'] == 'J')
                                    Pessoa Jurídica
                                @else
                                    Pessoa Física
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pessoas.edit', $pessoa['id']) }}" class="btn btn-warning btn-sm">
                                    Editar
                                </a>

                                <form action="{{ route('pessoas.destroy', $pessoa['id']) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">
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