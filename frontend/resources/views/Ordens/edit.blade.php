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
                                {{-- Lógica híbrida: verifica se o ID está dentro do objeto 'cliente' ou solto --}}
                                <option value="{{ $cliente['id'] }}" @if($cliente['id'] == ($ordem['cliente']['id'] ?? $ordem['cliente_id'] ?? '')) selected @endif>
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
                                {{-- Lógica híbrida para veículo também --}}
                                <option value="{{ $veiculo['id'] }}" @if($veiculo['id'] == ($ordem['veiculo']['id'] ?? $ordem['veiculo_id'] ?? '')) selected @endif>
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
                            <option value="ABERTA" @if($ordem['status'] == 'ABERTA') selected @endif>Aberta</option>
                            <option value="EM_ANDAMENTO" @if($ordem['status'] == 'EM_ANDAMENTO') selected @endif>Em Andamento</option>
                            <option value="CONCLUIDA" @if($ordem['status'] == 'CONCLUIDA') selected @endif>Concluída</option>
                            <option value="CANCELADA" @if($ordem['status'] == 'CANCELADA') selected @endif>Cancelada</option>
                        </select>
                    </div>
                    
                    {{-- Mantém a data original enviada pelo Java --}}
                    <input type="hidden" name="data_emissao" value="{{ $ordem['data_emissao'] }}">
                </div>

                {{-- O JavaScript vai injetar aqui os inputs ocultos dos itens --}}
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
    // Catálogo para buscar nomes
    const catalogoItens = @json($itens_catalogo);
    
    // --- CORREÇÃO FUNDAMENTAL: NORMALIZAÇÃO DE DADOS ---
    // Pega os dados crus que vieram do PHP (formato Java aninhado ou vazio)
    let itensRaw = @json($ordem['itens'] ?? []);

    // Transforma tudo para um formato padrão plano que o nosso script entende
    let itensDaOS = itensRaw.map(osItem => {
        return {
            id: osItem.id, // ID do relacionamento (importante para o Java saber qual atualizar)
            
            // Tenta pegar o ID do item dentro do objeto 'item' (padrão Java novo) 
            // ou direto em 'item_id' (padrão antigo/banco)
            item_id: osItem.item ? osItem.item.id : osItem.item_id,
            
            // Tenta pegar o nome. Se vier null, a gente busca no catálogo depois.
            item_nome: osItem.item ? osItem.item.nome : null,
            
            quantidade: osItem.quantidade,
            valor_unitario: osItem.valor_unitario
        };
    });

    // Elementos do DOM
    const selectItem = document.getElementById('select_item_id');
    const inputValor = document.getElementById('select_item_valor');
    const inputQtd = document.getElementById('select_item_qtd');
    const btnAddItem = document.getElementById('btn-add-item');
    const tabelaItens = document.getElementById('tabela-itens-os');
    const formOS = document.getElementById('form-os');
    const btnSalvarOS = document.getElementById('btn-salvar-os');
    const divHiddenInputs = document.getElementById('itens-hidden-inputs');

    // Atualiza preço ao selecionar item
    selectItem.addEventListener('change', () => {
        const selectedOption = selectItem.options[selectItem.selectedIndex];
        const preco = selectedOption.getAttribute('data-price');
        if (preco) {
            inputValor.value = parseFloat(preco).toFixed(2);
        } else {
            inputValor.value = 0;
        }
    });

    // Botão Adicionar Item
    btnAddItem.addEventListener('click', () => {
        const itemId = selectItem.value;
        const qtd = parseInt(inputQtd.value);
        const valor = parseFloat(inputValor.value);
        
        if (!itemId || qtd <= 0 || valor < 0) {
            alert('Por favor, selecione um item e verifique a quantidade e o valor.');
            return;
        }

        // Busca o nome para exibir na tabela
        const itemDoCatalogo = catalogoItens.find(i => i.id == itemId);
        const itemNome = itemDoCatalogo ? itemDoCatalogo.nome : 'Item Desconhecido';
        
        // Adiciona ao array local
        itensDaOS.push({
            id: null, // Novo item não tem ID de vínculo ainda
            item_id: itemId,
            item_nome: itemNome, 
            quantidade: qtd,
            valor_unitario: valor
        });
        
        renderizarTabela();
        
        // Limpa campos
        selectItem.value = "";
        inputValor.value = "";
        inputQtd.value = 1;
    });

    function renderizarTabela() {
        tabelaItens.innerHTML = "";
        
        itensDaOS.forEach((item, index) => {
            // Se o item veio do banco sem o nome preenchido, busca no catálogo agora
            if (!item.item_nome) {
                const itemDoCatalogo = catalogoItens.find(i => i.id == item.item_id);
                item.item_nome = itemDoCatalogo ? itemDoCatalogo.nome : 'Item (ID: ' + item.item_id + ')';
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

    // Gera os inputs hidden que serão enviados via POST/PUT
    function atualizarInputsOcultos() {
        divHiddenInputs.innerHTML = "";
        
        itensDaOS.forEach((item, index) => {
            // Se for item existente (edição), envia o ID do vínculo
            let inputIdVinculo = '';
            if (item.id) {
                inputIdVinculo = `<input type="hidden" name="itens[${index}][id]" value="${item.id}">`;
            }

            // Garante que item_id está preenchido
            divHiddenInputs.innerHTML += `
                ${inputIdVinculo}
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

    // Inicia a tabela ao carregar a página
    document.addEventListener('DOMContentLoaded', () => {
        renderizarTabela();
    });

</script>
@endpush