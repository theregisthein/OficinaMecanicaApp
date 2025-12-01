@extends('layout')

@section('content')
<div class="container">
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h3>Cadastrar Nova Pessoa</h3>
        </div>
        <div class="card-body">

            <form action="{{ route('pessoas.store') }}" method="POST">
                @csrf 

                <fieldset>
                    <legend class="text-primary mb-3">Dados Pessoais</legend>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nome" class="form-label">Nome Completo</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="{{ old('nome') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="telefone" name="telefone" minlength="9" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="{{ old('telefone') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="endereco" class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="endereco" name="endereco" value="{{ old('endereco') }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cpfcnpj" class="form-label">CPF/CNPJ</label>
                            <input type="text" class="form-control" id="cpfcnpj" name="cpfcnpj" value="{{ old('cpfcnpj') }}" required minlength="11" maxlength="14" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipo</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo" id="tipoFisica" value="fisica" 
                                        @if(old('tipo') == 'fisica' || old('tipo') === null) checked @endif required>
                                <label class="form-check-label" for="tipoFisica">Pessoa Física</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo" id="tipoJuridica" value="juridica"
                                        @if(old('tipo') == 'juridica') checked @endif>
                                <label class="form-check-label" for="tipoJuridica">Pessoa Jurídica</label>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <hr>
                
                <fieldset class="mt-4">
                    <legend class="text-primary mb-3">Configuração do Acesso e Perfil</legend>
                    <div class="row">
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Perfil da Pessoa</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="perfil" id="perfilFuncionario" value="ADMIN" 
                                       @if(old('perfil') == 'AFMIN') checked @endif required>
                                <label class="form-check-label" for="perfilFuncionario">
                                    **Funcionário** (Acesso ao sistema)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="perfil" id="perfilCliente" value="cliente"
                                       @if(old('perfil') == 'cliente' || old('perfil') === null) checked @endif>
                                <label class="form-check-label" for="perfilCliente">
                                    **Cliente** (Apenas cadastro)
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">E-mail (Login) *Opcional</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="E-mail para login, se houver.">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="senha" class="form-label">Senha *Opcional</label>
                            <input type="password" class="form-control" id="senha" name="senha">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="senha_confirmation" class="form-label">Confirme a Senha</label>
                            <input type="password" class="form-control" id="senha_confirmation" name="senha_confirmation">
                        </div>
                    </div>
                </fieldset>
                
                <hr class="mt-5">
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
                    @forelse ($pessoas as $pessoa)
                        <tr>
                            <td>{{ $pessoa['id'] }}</td>
                            <td>{{ $pessoa['nome'] }}</td>
                            <td>{{ $pessoa['telefone'] }}</td>
                            <td>{{ $pessoa['cpfcnpj'] }}</td>
                            
                            <td>
                                @if($pessoa['tipo'] == 'juridica')
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
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Nenhuma pessoa cadastrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection