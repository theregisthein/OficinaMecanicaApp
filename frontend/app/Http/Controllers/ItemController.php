<?php

namespace App\Http\Controllers;

use App\Models\item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ItemController extends Controller
{

    private $apiBaseUrl = 'http://localhost:8080/itens-proxy';

    public function index(){
    // 1. O Laravel chama o seu "Projeto BACKEND" (Java)
    // A URL deve ser do Controller do Projeto backend.
        $response = Http::get($this->apiBaseUrl);
    
    // 2. O seu "Projeto BACKEND" (Java) vai chamar o ItemClient...
    // 3. ...que vai chamar a "APIRest" (Java), que busca no banco...
    // 4. ...e tudo retorna para o Laravel.

    // 5. O Laravel pega o JSON e manda para a view
        $itens = $response->json(); 
        //dd($itens);
    
        return view("itens.index", ['itens' => $itens]);
    }



/**
     * Salvar um novo item (do formulário de cadastro)
     */
    public function store(Request $request)
    {
        // 1. Pega os dados do formulário
        $data = $request->only(['nome', 'descricao', 'marca', 'valor']);

        // 2. Envia os dados como JSON para a API Java (POST)
        $response = Http::post($this->apiBaseUrl, $data);

        // 3. Se falhar, volta com erro
        if ($response->failed()) {
            return back()->with('error', 'Falha ao salvar o item na API.');
        }

        // 4. Se der certo, redireciona para a lista
        return redirect()->route('itens.index')->with('success', 'Item criado com sucesso!');
    }

    /**
     * Mostrar o formulário de edição para um item específico
     */
    public function edit($id)
    {
        // 1. Busca os dados de UM item na API Java
        // (Assumindo que sua API tenha um GET /items-proxy/{id})
        $response = Http::get("{$this->apiBaseUrl}/{$id}");

        if ($response->failed()) {
            return redirect()->route('itens.index')->with('error', 'Item não encontrado na API.');
        }

        $item = $response->json();

        // 2. Envia o item para a nova view 'itens.edit'
        return view('itens.edit', ['item' => $item]);
    }

    /**
     * Atualizar um item (do formulário de edição)
     */
    public function update(Request $request, $id)
    {
        // 1. Pega os dados do formulário de edição
        $data = $request->only(['nome', 'descricao', 'marca', 'valor']);

        // 2. Envia os dados para a API Java (PUT)
        // (Assumindo que sua API tenha um PUT /items-proxy/{id})
        $response = Http::put("{$this->apiBaseUrl}/{$id}", $data);

        if ($response->failed()) {
            return back()->with('error', 'Falha ao atualizar o item na API.');
        }

        // 3. Redireciona de volta para a lista
        return redirect()->route('itens.index')->with('success', 'Item atualizado com sucesso!');
    }

    /**
     * Remover um item (botão Excluir)
     */
    public function destroy($id)
    {
        // 1. Chama o método DELETE na API Java
        // (Assumindo que sua API tenha um DELETE /items-proxy/{id})
        $response = Http::delete("{$this->apiBaseUrl}/{$id}");

        if ($response->failed()) {
            return back()->with('error', 'Falha ao excluir o item na API.');
        }

        // 2. Redireciona de volta para a lista
        return redirect()->route('itens.index')->with('success', 'Item excluído com sucesso!');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }



    /**
     * Display the specified resource.
     */
    public function show(item $item)
    {
        //
    }


}
