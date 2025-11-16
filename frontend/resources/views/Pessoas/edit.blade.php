@extends('layout')

@section('content')
<div class="container">
    <div class="card mb-4">
        <div class="card-header bg-warning">
            <h3>Editar Pessoa: {{ $pessoa['nome'] ?? '' }}</h3>
        </div>
        <div class="card-body">

            <form action="{{ route('pessoas.update', $pessoa['id']) }}" method="POST">
                @csrf
                @method('PUT') 

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" 
                               value="{{ $pessoa['nome'] ?? '' }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="telefone" class="form-label">Telefone</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" minlength="9" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               value="{{ $pessoa['telefone'] ?? '' }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="endereco" class="form-label">Endereço</label>
                    <input type="text" class="form-control" id="endereco" name="endereco"
                           value="{{ $pessoa['endereco'] ?? '' }}">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cpfcnpj" class="form-label">CPF/CNPJ</label>
                        <input type="text" class="form-control" id="cpfcnpj" name="cpfcnpj" value="{{ $pessoa['cpfcnpj'] ?? '' }}" required minlength="11" maxlength="14" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                    
                    {{-- CAMPO TIPO (Radio Button F/J com lógica 'checked') --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tipo</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo" id="tipoFisica" value="F" 
                                   @if($pessoa['tipo'] != 'J') checked @endif>
                            <label class="form-check-label" for="tipoFisica">
                                Pessoa Física
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo" id="tipoJuridica" value="J"
                                   @if($pessoa['tipo'] == 'J') checked @endif>
                            <label class="form-check-label" for="tipoJuridica">
                                Pessoa Jurídica
                            </label>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('pessoas.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection