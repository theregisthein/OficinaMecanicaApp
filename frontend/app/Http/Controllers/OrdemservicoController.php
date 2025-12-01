<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon; // Para lidar com datas
use Illuminate\Support\Collection; // Necessário para a função collect()

class OrdemservicoController extends Controller
{
     //URLs das APIs PARA LOCAL
    private $apiOsUrl = 'http://localhost:8080/ordens-proxy';
    private $apiPessoasUrl = 'http://localhost:8080/pessoas-proxy';
    private $apiVeiculosUrl = 'http://localhost:8080/veiculos-proxy';
    private $apiItensUrl = 'http://localhost:8080/items-proxy';

    //private $apiBaseHost = 'http://proxycrud:8080';
    //private $apiOsUrl = 'http://proxycrud:8080/ordens-proxy';
    //private $apiPessoasUrl = 'http://proxycrud:8080/pessoas-proxy';
    //private $apiVeiculosUrl = 'http://proxycrud:8080/veiculos-proxy';
    //private $apiItensUrl = 'http://proxycrud:8080/items-proxy';


    public function index()
    {
        try {
            $responseOs = Http::get($this->apiOsUrl);
            $ordens = $responseOs->json();

            if (!is_array($ordens) || $responseOs->failed()) {
                 return view('ordens.index', ['ordens' => []])
                    ->with('error', 'Falha ao buscar Ordens de Serviço.');
            }

            // 2. Buscar TODOS os Clientes e Veículos (Para pegar os nomes)
            // (Isso é necessário porque seu Java talvez não esteja mandando o nome, só o ID)
            $clientes = Http::get($this->apiPessoasUrl)->json();
            $veiculos = Http::get($this->apiVeiculosUrl)->json();
            
            // 3. Mapear para acesso rápido
            $clientesMap = Collection::make($clientes)->keyBy('id');
            $veiculosMap = Collection::make($veiculos)->keyBy('id');
            
            // 4. CORREÇÃO AQUI: Ler o ID de dentro do Objeto
            $ordensEnriquecidas = Collection::make($ordens)->map(function ($ordem) use ($clientesMap, $veiculosMap) {
                
                // Tenta pegar 'cliente_id' (jeito antigo) OU 'cliente.id' (jeito novo objeto)
                $clienteId = $ordem['cliente_id'] ?? $ordem['cliente']['id'] ?? null;
                $veiculoId = $ordem['veiculo_id'] ?? $ordem['veiculo']['id'] ?? null;

                // Enriquecimento do Cliente
                $cliente = $clientesMap->get($clienteId);
                $ordem['nome_cliente'] = $cliente['nome'] ?? 'Cliente não encontrado (ID: '.$clienteId.')';

                // Enriquecimento do Veículo
                $veiculo = $veiculosMap->get($veiculoId);
                if ($veiculo) {
                    $ordem['desc_veiculo'] = "{$veiculo['marca']} {$veiculo['modelo']} ({$veiculo['placa']})";
                } else {
                    $ordem['desc_veiculo'] = 'Veículo não encontrado (ID: '.$veiculoId.')';
                }
                
                // Formata a data para ficar bonita na tabela
                if (isset($ordem['data_emissao'])) {
                    $ordem['data_emissao'] = date('d/m/Y H:i', strtotime($ordem['data_emissao']));
                }

                return $ordem;
            })->toArray();

        } catch (\Exception $e) {
            return view('ordens.index', ['ordens' => []])
                ->with('error', 'Erro de conexão: ' . $e->getMessage());
        }
        
        return view('ordens.index', ['ordens' => $ordensEnriquecidas]);
    }

    public function create()
    {
        try {
            // busca dados de 3 APIs para preencher os <select> do formulário
            $clientes = Http::get($this->apiPessoasUrl)->json();
            $veiculos = Http::get($this->apiVeiculosUrl)->json();
            $itens = Http::get($this->apiItensUrl)->json();

        } catch (\Exception $e) {
            return redirect()->route('ordens.index')
                           ->with('error', 'Não foi possível carregar os dados das APIs (Clientes, Veículos ou Itens). Verifique o Java.');
        }

        return view('ordens.create', ['clientes' => $clientes, 'veiculos' => $veiculos, 'itens' => $itens]);
    }

    
    //Salva a nova Ordem de Serviço (Mãe + Filhos)
    
    public function store(Request $request)
    {
        // Monta o Objeto PAI (Ordem)
        $dadosOs = [
            'cliente' => ['id' => (int)$request->cliente_id], 
            'veiculo' => ['id' => (int)$request->veiculo_id],
            'status' => $request->status,
            'data_emissao' => Carbon::now()->toIso8601String(), 
        ];

        // Monta a Lista de FILHOS (Itens)
        $itens_da_os = [];
        if ($request->has('itens')) {
            foreach ($request->itens as $item) {
                $itens_da_os[] = [
                    // 'item' vira um objeto com 'id' dentro
                    'item' => ['id' => (int)$item['item_id']],
                    'quantidade' => (float)$item['quantidade'],
                    'valor_unitario' => (float)$item['valor_unitario'],
                ];
            }
        }
        
        // Junta tudo
        $dadosCompletos = $dadosOs;
        $dadosCompletos['itens'] = $itens_da_os;

        // Envia
        $response = Http::post($this->apiOsUrl, $dadosCompletos);

        if ($response->failed()) {
            return back()->with('error', 'Falha ao salvar a OS: ' . $response->body());
        }

        return redirect()->route('ordens.index')->with('success', 'OS criada com sucesso!');
    }


    public function edit($id)
    {
        try {
            //busca os dados da OS específica (já com a lista de itens)
            $ordem = Http::get("{$this->apiOsUrl}/{$id}")->json();
            
            // busca os dados para os selects
            $clientes = Http::get($this->apiPessoasUrl)->json();
            $veiculos = Http::get($this->apiVeiculosUrl)->json();
            $itens = Http::get($this->apiItensUrl)->json();

            
        } catch (\Exception $e) {
            return redirect()->route('ordens.index')->with('error', 'Não foi possível carregar os dados da OS ou das APIs.');
        }

        return view('ordens.edit', [
            'ordem' => $ordem,
            'clientes' => $clientes,
            'veiculos' => $veiculos,
            'itens_catalogo' => $itens
        ]);
    }


    public function update(Request $request, $id)
    {
        $dadosOs = [
            'id' => (int)$id,
            'cliente' => ['id' => (int)$request->cliente_id],
            'veiculo' => ['id' => (int)$request->veiculo_id],
            'status' => $request->status,
            // Mantém data original se vier, senão usa agora
            'data_emissao' => $request->data_emissao ?? Carbon::now()->toIso8601String(),
        ];

        $itens_da_os = [];
        if ($request->has('itens')) {
            foreach ($request->itens as $item) {
                $osItemId = isset($item['id']) ? (int)$item['id'] : null;

                $itens_da_os[] = [
                    'id' => $osItemId,
                    'item' => ['id' => (int)$item['item_id']],
                    'quantidade' => (int)$item['quantidade'],
                    'valor_unitario' => (float)$item['valor_unitario'],
                ];
            }
        }
        
        $dadosCompletos = $dadosOs;
        $dadosCompletos['itens'] = $itens_da_os;

        $response = Http::put("{$this->apiOsUrl}/{$id}", $dadosCompletos);

        if ($response->failed()) {
            return back()->with('error', 'Falha ao atualizar a OS: ' . $response->body());
        }

        return redirect()->route('ordens.index')->with('success', 'Ordem de Serviço atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $response = Http::delete("{$this->apiOsUrl}/{$id}");

        if ($response->failed()) {
            return redirect()->back()->with('error', 'Falha ao excluir a OS.');
        }

        return redirect()->route('ordens.index')->with('success', 'Ordem de Serviço excluída com sucesso!');
    }
}