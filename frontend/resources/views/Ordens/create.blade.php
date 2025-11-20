@extends('layout')

@section('content')
<div class="container">
    
    <div class="card mb-4">
        <div class="card-header">
            <h3>Criar Nova Ordem de Serviço</h3>
        </div>
        <div class="card-body">

            {{-- O FORMULÁRIO PRINCIPAL (MÃE) --}}
            <form action="{{ route('ordens.store') }}" method="POST" id="form-os">
                @csrf 
                
                {{-- 1. CABEÇALHO DA OS --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cliente_id" class="form-label">Cliente</label>
                        <select id="cliente_id" name="cliente_id" class="form-control" required>
                            <option value="">Selecione um cliente...</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente['id'] }}">{{ $cliente['nome'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="veiculo_id" class="form-label">Veículo</label>
                        <select id="veiculo_id" name="veiculo_id" class="form-control" required>
                            <option value="">Selecione um veículo...</option>
                            @foreach ($veiculos as $veiculo)
                                <option value="{{ $veiculo['id'] }}">{{ $veiculo['marca'] }} {{ $veiculo['modelo'] }} (Placa: {{ $veiculo['placa'] }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="ABERTA" selected>Aberta</option>
                            <option value="EM_ANDAMENTO">Em Andamento</option>
                            <option value="CONCLUIDA">Concluída</option>
                            <option value="CANCELADA">Cancelada</option>
                        </select>
                    </div>
                </div>

                {{-- o JavaScript vai injetar os inputs ocultos --}}
                <div id="itens-hidden-inputs"></div>
            </form>

            <hr>

            {{-- FORMULÁRIO PARA ADICIONAR ITENS (FILHOS) --}}
            <h4 class="mt-4">Itens da OS</h4>
            <div class="card bg-light p-3">
                <div class="row">
                    <div class="col-md-5">
                        <label for="select_item_id">Item</label>
                        <select id="select_item_id" class="form-control">
                            <option value="">Selecione um item...</option>
                            {{-- data-price guarda o preço para o JS pegar --}}
                            @foreach ($itens as $item)
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
                <button type="button" id="btn-salvar-os" class="btn btn-success">Salvar Ordem de Serviço</button>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- PUSH DE SCRIPTS: Onde a mágica do JS acontece --}}
@push('scripts')
<script>
    // Armazena os dados que o PHP passou (o catálogo de itens)
    const catalogoItens = @json($itens);
    
    //array (carrinho) que guarda os itens adicionados
    let itensDaOS = [];

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
        // pega o <option> selecionado
        const selectedOption = selectItem.options[selectItem.selectedIndex];
        
        // pega o 'data-price' do HTML
        const preco = selectedOption.getAttribute('data-price');
        
        // coloca o preço no campo de valor
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
        
        if (!itemId || qtd <= 0 || valor <= 0) {
            alert('Por favor, selecione um item e verifique a quantidade e o valor.');
            return;
        }

        // pega nome do item pra mostrar na tabela
        const itemNome = selectItem.options[selectItem.selectedIndex].text;
        
        // adiciona o item ao "carrinho"
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

    // desenha a tabela de itens
    function renderizarTabela() {

        tabelaItens.innerHTML = "";
        
        // desenha a tabela com os itens do "carrinho"
        itensDaOS.forEach((item, index) => {
            const totalItem = item.quantidade * item.valor_unitario;
            
            const row = `
                <tr>
                    <td>${item.item_nome}</td>
                    <td>${item.quantidade}</td>
                    <td>R$ ${item.valor_unitario.toFixed(2)}</td>
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
        
        // atualiza os inputs ocultos que serao enviados pro PHP
        atualizarInputsOcultos();
    }

    function removerItem(index) {
        itensDaOS.splice(index, 1);
        
        renderizarTabela();
    }

    // preenche o formulário pro PHP
    function atualizarInputsOcultos() {
        divHiddenInputs.innerHTML = "";
        
        // cria os <input type="hidden" ...> pro PHP receber
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
        
        // envia formulário principal com os inputs ocultos
        formOS.submit();
    });

</script>
@endpush