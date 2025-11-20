<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ItemController extends Controller
{

    private $apiBaseUrl = 'http://localhost:8080/items-proxy';

    public function index(){
    // o Laravel chama o back do crud
    // A URL é a que foi definida no controller do crud no back.
        $response = Http::get($this->apiBaseUrl);
    
    // o back chama o ItemClient 
    // ItemClient chama a "APIRest" e ela busca no banco retornando tudo para o laravel

    //  o laravel pega o JSON e manda para a view
        $itens = $response->json(); 
        //dd($itens);
    
        return view("itens.index", ['itens' => $itens]);
    }



    public function store(Request $request)
    {
        // capturta os dados do formulário
        $data = $request->only(['nome', 'descricao', 'marca', 'preco']);
        
        // envia estes dados como JSON para o Crud
        $response = Http::post($this->apiBaseUrl, $data);

        // se falhar volta com erro
        if ($response->failed()) {
            return back()->with('error', 'Falha ao salvar o item na API.');
        }

        // se der certo redireciona para a lista
        return redirect()->route('itens.index')->with('success', 'Item criado com sucesso!');
    }

    
    public function edit($id)
    {
        // busca os dados de UM item no crud se o crud ter um GET /items-proxy/{id})
        $response = Http::get("{$this->apiBaseUrl}/{$id}");

        if ($response->failed()) {
            return redirect()->route('itens.index')->with('error', 'Item não encontrado na API.');
        }

        $item = $response->json();

        return view('itens.edit', ['item' => $item]);
    }


    public function update(Request $request, $id)
    {
        // pega os dados do formulário de edição
        $data = $request->only(['nome', 'descricao', 'marca', 'preco']);

        // envia os dados para o crud por metodo PUT
        $response = Http::put("{$this->apiBaseUrl}/{$id}", $data);

        if ($response->failed()) {
            return back()->with('error', 'Falha ao atualizar o item na API.');
        }

        return redirect()->route('itens.index')->with('success', 'Item atualizado com sucesso!');
    }


    public function destroy($id)
    {
        // manda a requisição DELETE para o crud 
        $response = Http::delete("{$this->apiBaseUrl}/{$id}");

        if ($response->failed()) {
            return redirect()->back()->with('error', 'Falha ao excluir o item na API.');
        }

        return redirect()->route('itens.index')->with('success', 'Item excluído com sucesso!');
    }



    public function create()
    {
        //
    }



    public function show(item $item)
    {
        //
    }


}
