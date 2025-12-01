@extends('layout')

@section('content')
<div class="container">
    
    {{-- Exibição de Mensagens de Sucesso ou Erro --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Ordens de Serviço</h3>
                <a href="{{ route('ordens.create') }}" class="btn btn-primary">
                    + Criar Nova OS
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">OS Nº</th>
                        <th scope="col">Cliente</th>        {{-- CAMPO ENRIQUECIDO --}}
                        <th scope="col">Veículo</th>        {{-- CAMPO ENRIQUECIDO --}}
                        <th scope="col">Data Emissão</th>
                        <th scope="col">Status</th>
                        <th scope="col" style="width: 150px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ordens as $ordem)
                        <tr>
                            <td>{{ $ordem['id'] }}</td>
                            
                            {{-- EXIBINDO NOME DO CLIENTE ENRIQUECIDO PELO CONTROLLER --}}
                            <td><strong>{{ $ordem['nome_cliente'] ?? 'N/A' }}</strong></td> 
                            
                            {{-- EXIBINDO DESCRIÇÃO DO VEÍCULO ENRIQUECIDA PELO CONTROLLER --}}
                            <td>{{ $ordem['desc_veiculo'] ?? 'N/A' }}</td>
                            
                            <td>
                                {{-- formata a data padrão Brasil --}}
                                {{ $ordem['data_emissao'] }}
                            </td>
                            <td>
                                @if($ordem['status'] == 'ABERTA')
                                    <span class="badge bg-primary">Aberta</span>
                                @elseif($ordem['status'] == 'CONCLUIDA')
                                    <span class="badge bg-success">Concluída</span>
                                @elseif($ordem['status'] == 'CANCELADA')
                                    <span class="badge bg-danger">Cancelada</span>
                                @else
                                    <span class="badge bg-warning text-dark">{{ $ordem['status'] }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('ordens.edit', $ordem['id']) }}" class="btn btn-warning btn-sm">
                                    Editar
                                </a>

                                <form action="{{ route('ordens.destroy', $ordem['id']) }}" method="POST" style="display:inline;">
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
                            <td colspan="6" class="text-center">Nenhuma Ordem de Serviço encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection