<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
Use Illuminate\Support\Facades\Log;

class PessoaController extends Controller
{
    //PARA LOCAL
    private $apiBaseUrl = 'http://localhost:8080/pessoas-proxy';
    
    //private $apiBaseUrl = 'http://proxycrud:8080/pessoas-proxy';

    public function index()
    {
        $pessoas = [];
        $errorMessage = null;

        try {
            $response = Http::get($this->apiBaseUrl);

            if ($response->successful()) {
                $data = $response->json();
                
                
                if (is_array($data)) {
                    $pessoas = $data;
                } else {
                    Log::error('API Pessoa retornou 200, mas o JSON é inválido ou nulo.');
                    $errorMessage = 'Dados inválidos recebidos do backend.';
                }

            } else {
                $status = $response->status();
                $body = $response->body();
                Log::error("API Pessoa falhou. Status: {$status}. Body: {$body}");
                $errorMessage = "Falha ao carregar pessoas (Status: {$status}).";
            }

        } catch (\Exception $e) {
            Log::error('Erro de conexão com API Pessoa: ' . $e->getMessage());
            $errorMessage = 'Serviço de Pessoas indisponível. Verifique o Docker/Proxy.';
        }
        
        if ($errorMessage) {
            return view("pessoas.index", ['pessoas' => $pessoas])->with('error', $errorMessage);
        }

        return view("pessoas.index", ['pessoas' => $pessoas]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->only(['nome', 'telefone', 'endereco', 'cpfcnpj', 'tipo', 'perfil', 'email', 'senha']);
        $response = Http::post($this->apiBaseUrl, $data);

        if ($response->failed()) {
            return back()->with('error', 'Falha ao salvar a pessoa na API.');
        }

        return redirect()->route('pessoas.index')->with('success', 'Pessoa criada com sucesso!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $response = Http::get("{$this->apiBaseUrl}/{$id}");

        if ($response->failed()) {
            return redirect()->route('pessoas.index')->with('error', 'Pessoa não encontrada na API.');
        }

        $pessoa = $response->json();

        return view('pessoas.edit', ['pessoa' => $pessoa]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only(['nome', 'telefone', 'endereco', 'cpfcnpj', 'tipo', 'perfil', 'email', 'senha']); 
        $response = Http::put("{$this->apiBaseUrl}/{$id}", $data);

        if ($response->failed()) {
            return back()->with('error', 'Falha ao atualizar a pessoa na API.');
        }

        return redirect()->route('pessoas.index')->with('success', 'Pessoa atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $response = Http::delete("{$this->apiBaseUrl}/{$id}");

        if ($response->failed()) {
            $errorMessage = $response->json()['message'] ?? 'Falha ao excluir. Pessoa pode estar em uso.';
            return redirect()->back()->with('error', $errorMessage);
        }

        return redirect()->route('pessoas.index')->with('success', 'Pessoa excluída com sucesso!');
    }

    public function toggleStatus($id)
    {
        $response = Http::patch("{$this->apiBaseUrl}/{$id}/toggle-status");

        if ($response->failed()) {
            return redirect()->back()->with('error', 'Falha ao alterar o status.');
        }

        return redirect()->route('pessoas.index')->with('success', 'Status alterado!');
    }
}