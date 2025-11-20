@extends('layout')

@section('content')
<div class="container">
    
    <div class="card mb-4">
        <div class="card-header bg-warning">
            <h3>Editar Ordem de Serviço Nº {{ $ordem['id'] }}</h3>
        </div>
        <div class="card-body">

            <form action="{{ route('ordens.update', $ordem['id']) }}" method="POST" id="form-os">
                @csrf 
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cliente_id" class="form-label">Cliente</label>
                        <select id="cliente_id" name="cliente_id" class="form-control" required>
                            <option value="">Selecione um cliente...</option>
                            @foreach ($clientes as $cliente)
                                {{-- para marcar o cliente salvo --}}
                                <option value="{{ $cliente['id'] }}" @if($cliente['id'] == $ordem['cliente_id']) selected @endif>
                                    {{ $cliente['nome'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="veiculo_id" class="form-label">Veículo</label>
                        <select id="veiculo_id" name="veiculo_id" class="form-control" required>
                            <option value="">Selecione um veículo...</option>
                            @foreach ($veiculos as $veiculo)
                                {{-- para marcar o veículo salvo --}}
                                <option value="{{ $veiculo['id'] }}" @if($veiculo['id'] == $ordem['veiculo_id']) selected @endif>
                                    {{ $veiculo['marca'] }} {{ $veiculo['modelo'] }} (Placa: {{ $veiculo['placa'] }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-control" required>
                            {{-- para marcar o status salvo --}}
                            <option value="ABERTA" @if($ordem['status'] == 'ABERTA') selected @endif>Aberta</option>
                            <option value="EM_ANDAMENTO" @if($ordem['status'] == 'EM_ANDAMENTO') selected @endif>Em Andamento</option>
                            <option value="CONCLUIDA" @if($ordem['status'] == 'CONCLUIDA') selected @endif>Concluída</option>
                            <option value="CANCELADA" @if($ordem['status'] == 'CANCELADA') selected @endif>Cancelada</option>
                        </select>
                    </div>
                    
                    {{-- campo oculto para manter a data de emissao original --}}
                    <input type="hidden" name="data_emissao" value="{{ $ordem['data_emissao'] }}">
                </div>

                {{-- Oode JavaScript injeta os inputs ocultos --}}
                <div id="itens-hidden-inputs"></div>
            </form>

            <hr>

            <h4 class="mt-4">Itens da OS</h4>
            <div class="card bg-light p-3">
                <div class="row">
                    <div class="col-md-5">
                        <label for="select_item_id">Item</label>
                        <select id="select_item_id" class="form-control">
                            <option value="">Selecione um item...</option>
                            {{-- $itens_catalogo vem do controller --}}
                            @foreach ($itens_catalogo as $item)
                                <option value="{{ $item['id'] }}" data-price="{{ $item['preco'] }}">
                                    {{ $item['nome'] }} (R$ {{ number_format($item['preco'], 2, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="select_item_valor">Valor Unitário (R$)</label>
                        <input type="number" id="select_item_valor" class="form-control" step="0.01">
                    </div>
                    <div class="col-md-2">
                        <label for="select_item_qtd">Qtd.</label>
                        <input type="number" id="select_item_qtd" class="form-control" value="1" min="1">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" id="btn-add-item" class="btn btn-primary w-100">Adicionar +</button>
                    </div>
                </div>
            </div>



            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qtd.</th>
                        <th>Valor Unit.</th>
                        <th>Valor Total</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody id="tabela-itens-os"></tbody>
            </table>

            <hr>
            <div class="d-flex justify-content-end">
                <a href="{{ route('ordens.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                <button type="button" id="btn-salvar-os" class="btn btn-success">Salvar Alterações</button>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
    // guarda os dados que o PHP passou
    const catalogoItens = @json($itens_catalogo);
    
    // pre-carrega o "carrinho" com os itens existentes da OS
    let itensDaOS = @json($ordem['itens'] ?? []);

    // pega os elementos do HTML
    const selectItem = document.getElementById('select_item_id');
    const inputValor = document.getElementById('select_item_valor');
    const inputQtd = document.getElementById('select_item_qtd');
    const btnAddItem = document.getElementById('btn-add-item');
    const tabelaItens = document.getElementById('tabela-itens-os');
    const formOS = document.getElementById('form-os');
    const btnSalvarOS = document.getElementById('btn-salvar-os');
    const divHiddenInputs = document.getElementById('itens-hidden-inputs');

    // quando o usuário escolhe um item no select
    selectItem.addEventListener('change', () => {
        const selectedOption = selectItem.options[selectItem.selectedIndex];
        const preco = selectedOption.getAttribute('data-price');
        if (preco) {
            inputValor.value = parseFloat(preco).toFixed(2);
        } else {
            inputValor.value = 0;
        }
    });

    btnAddItem.addEventListener('click', () => {
        const itemId = selectItem.value;
        const qtd = parseInt(inputQtd.value);
        const valor = parseFloat(inputValor.value);
        
        if (!itemId || qtd <= 0 || valor < 0) { // permitido valor 0 por garantia
            alert('Por favor, selecione um item e verifique a quantidade e o valor.');
            return;
        }

        // pega o nome do item pra mostrar na tabela
        const itemDoCatalogo = catalogoItens.find(i => i.id == itemId);
        const itemNome = itemDoCatalogo ? itemDoCatalogo.nome : 'Item Desconhecido';
        
        itensDaOS.push({
            item_id: itemId,
            item_nome: itemNome, 
            quantidade: qtd,
            valor_unitario: valor
        });
        
        renderizarTabela();
        
        selectItem.value = "";
        inputValor.value = "";
        inputQtd.value = 1;
    });

    function renderizarTabela() {
        tabelaItens.innerHTML = "";
        
        itensDaOS.forEach((item, index) => {
            // Ss o item_nome nao veio (porque estava carregado do $ordem), busca no catálogo
            if (!item.item_nome) {
                const itemDoCatalogo = catalogoItens.find(i => i.id == item.item_id);
                item.item_nome = itemDoCatalogo ? itemDoCatalogo.nome : 'Item Carregado';
            }
            
            const totalItem = (item.quantidade || 0) * (item.valor_unitario || 0);
            
            const row = `
                <tr>
                    <td>${item.item_nome}</td>
                    <td>${item.quantidade}</td>
                    <td>R$ ${parseFloat(item.valor_unitario).toFixed(2)}</td>
                    <td>R$ ${totalItem.toFixed(2)}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="removerItem(${index})">
                            Remover
                        </button>
                    </td>
                </tr>
            `;
            tabelaItens.innerHTML += row;
        });
        
        atualizarInputsOcultos();
    }

    function removerItem(index) {
        itensDaOS.splice(index, 1);
        renderizarTabela();
    }

    // preencher o formulário pro PHP
    function atualizarInputsOcultos() {
        divHiddenInputs.innerHTML = "";
        
        itensDaOS.forEach((item, index) => {
            divHiddenInputs.innerHTML += `
                <input type="hidden" name="itens[${index}][item_id]" value="${item.item_id}">
                <input type="hidden" name="itens[${index}][quantidade]" value="${item.quantidade}">
                <input type="hidden" name="itens[${index}][valor_unitario]" value="${item.valor_unitario}">
            `;
        });
    }


    btnSalvarOS.addEventListener('click', () => {
        if (!document.getElementById('cliente_id').value || !document.getElementById('veiculo_id').value) {
            alert('Por favor, selecione um Cliente e um Veículo.');
            return;
        }
        if (itensDaOS.length === 0) {
            alert('Você precisa adicionar pelo menos um item à OS.');
            return;
        }
        
        formOS.submit();
    });


    // Assim que a página carregar, desenha a tabela com os itens que vieram do banco
    document.addEventListener('DOMContentLoaded', () => {
        renderizarTabela();
    });

</script>
@endpush