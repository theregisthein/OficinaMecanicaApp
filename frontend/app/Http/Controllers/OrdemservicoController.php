<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon; // Para lidar com datas

class OrdemservicoController extends Controller
{
    // URLs das suas APIs
    private $apiOsUrl = 'http://localhost:8080/ordens-proxy';
    private $apiPessoasUrl = 'http://localhost:8080/pessoas-proxy';
    private $apiVeiculosUrl = 'http://localhost:8080/veiculos-proxy';
    private $apiItensUrl = 'http://localhost:8080/items-proxy';


    public function index()
    {
        try {
            $response = Http::get($this->apiOsUrl);
            $ordens = $response->json();
        } catch (\Exception $e) {
            $ordens = [];
        }
        
        return view('ordens.index', ['ordens' => $ordens]);
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
        // Monta o cabeçalho (a "Mãe")
        $dadosOs = [
            'cliente_id' => $request->cliente_id,
            'veiculo_id' => $request->veiculo_id,
            'status' => $request->status,
            'data_emissao' => Carbon::now()->toIso8601String(), 
        ];

        // Monta a lista de "Filhos" (os itens)
        // O JavaScript vai enviar os itens como arrays
        $itens_da_os = [];
        if ($request->has('itens')) {
            foreach ($request->itens as $item) {
                //$item é um array vindo do form: [item_id, quantidade, valor_unitario]
                $itens_da_os[] = [
                    'item_id' => (int)$item['item_id'],
                    'quantidade' => (int)$item['quantidade'],
                    'valor_unitario' => (float)$item['valor_unitario'],
                    //valor_total será calculado pela API 9090
                ];
            }
        }
        
        //junta a mãe(Ordem) e os filhos(Itens) no JSON
        $dadosCompletos = $dadosOs;
        $dadosCompletos['itens'] = $itens_da_os;

        //envia para o Proxy 8080
        $response = Http::post($this->apiOsUrl, $dadosCompletos);

        if ($response->failed()) {
            return back()->with('error', 'Falha ao salvar a OS na API: ' . $response->body());
        }

        return redirect()->route('ordens.index')->with('success', 'Ordem de Serviço criada com sucesso!');
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
            dd("A API FALHOU COM UMA EXCEÇÃO: " . $e->getMessage());
            return redirect()->route('ordens.index')->with('error', 'Não foi possível carregar os dados da OS ou das APIs.');
        }

        return view('ordens.edit', ['ordem' => $ordem, 'clientes' => $clientes,'veiculos' => $veiculos, 'itens_catalogo' => $itens
        ]);
    }


    public function update(Request $request, $id)
    {
        // mesma coisa de Store mas usa Http::put
        
        $dadosOs = [
            'cliente_id' => $request->cliente_id,
            'veiculo_id' => $request->veiculo_id,
            'status' => $request->status,
            'data_emissao' => $request->data_emissao, // Mantém a data original
        ];

        $itens_da_os = [];
        if ($request->has('itens')) {
            foreach ($request->itens as $item) {
                $itens_da_os[] = [
                    'item_id' => (int)$item['item_id'],
                    'quantidade' => (int)$item['quantidade'],
                    'valor_unitario' => (float)$item['valor_unitario'],
                ];
            }
        }
        
        $dadosCompletos = $dadosOs;
        $dadosCompletos['itens'] = $itens_da_os;

        // USA PUT E A URL COM ID
        $response = Http::put("{$this->apiOsUrl}/{$id}", $dadosCompletos);

        if ($response->failed()) {
            return back()->with('error', 'Falha ao atualizar a OS na API: ' . $response->body());
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