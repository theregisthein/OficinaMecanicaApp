<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ItemController extends Controller
{
    private $apiBaseUrl = 'http://localhost:8080/items-proxy';

    public function index()
    {
        $itens = [];
        $errorMessage = null;

        try {
            $response = Http::get($this->apiBaseUrl);

            if ($response->failed()) {
                $errorMessage = "API retornou erro: " . $response->status();
            } else {
                $data = $response->json();

                if (is_array($data) && count($data) > 0) {
                    $primeiraChave = array_key_first($data);

                    if ($primeiraChave !== 0) {
                        $itens = [$data];
                    } else {
                        $itens = $data;
                    }
                } else {
                    $itens = [];
                }
            }

        } catch (\Exception $e) {
            $errorMessage = "Erro de conexão: " . $e->getMessage();
        }

        return view("itens.index", ['itens' => $itens])->with('error', $errorMessage);
    }

    public function create()
    {
        return view('itens.create');
    }

    public function store(Request $request)
    {
        $data = $request->only(['nome', 'marca', 'preco']);

        if (isset($data['preco'])) {
            $data['preco'] = str_replace(',', '.', $data['preco']);
        }
        
        $response = Http::post($this->apiBaseUrl, $data);

        if ($response->failed()) {
            return back()->with('error', 'Falha na API: ' . $response->body());
        }

        return redirect()->route('itens.index')->with('success', 'Item criado com sucesso!');
    }

    public function edit($id)
    {
        $response = Http::get("{$this->apiBaseUrl}/{$id}");

        if ($response->failed()) {
            return redirect()->route('itens.index')->with('error', 'Item não encontrado.');
        }

        $item = $response->json();
        return view('itens.edit', ['item' => $item]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only(['nome', 'marca', 'preco']);

        if (isset($data['preco'])) {
            $data['preco'] = str_replace(',', '.', $data['preco']);
        }

        $response = Http::put("{$this->apiBaseUrl}/{$id}", $data);

        if ($response->failed()) {
            return back()->with('error', 'Falha ao atualizar: ' . $response->body());
        }

        return redirect()->route('itens.index')->with('success', 'Item atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $response = Http::delete("{$this->apiBaseUrl}/{$id}");

        if ($response->failed()) {
            return redirect()->back()->with('error', 'Falha ao excluir. Item pode estar em uso.');
        }

        return redirect()->route('itens.index')->with('success', 'Item excluído com sucesso!');
    }
}