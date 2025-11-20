@extends('layout')

@section('content')
<div class="container">
    
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
                        <th scope="col">Cliente ID</th>
                        <th scope="col">Veículo ID</th>
                        <th scope="col">Data Emissão</th>
                        <th scope="col">Status</th>
                        <th scope="col" style="width: 150px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ordens as $ordem)
                        <tr>
                            <td>{{ $ordem['id'] }}</td>
                            <td>{{ $ordem['cliente_id'] }}</td>
                            <td>{{ $ordem['veiculo_id'] }}</td>
                            <td>
                                {{-- formata a data padrão Brasil --}}
                                {{ \Carbon\Carbon::parse($ordem['data_emissao'])->format('d/m/Y H:i') }}
                            </td>
                            <td>
                                {{-- Mostra um badge colorido para o status --}}
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
                        
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection