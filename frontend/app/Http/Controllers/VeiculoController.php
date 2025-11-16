<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class VeiculoController extends Controller
{

    private $apiBaseUrl = 'http://localhost:8080/veiculos-proxy';
 
    public function index()
    {
        $response = Http::get($this->apiBaseUrl);
        $veiculos = $response->json(); 
        return view("veiculos.index", ['veiculos' => $veiculos]);
    }

  
    public function create()
    {
        //
    }

 
    
    public function store(Request $request)
    {
        $data = $request->only(['marca', 'modelo', 'placa', 'ano', 'cor']);
        $response = Http::post($this->apiBaseUrl, $data);

        if ($response->failed()) {
            return back()->with('error', 'Falha ao salvar o veiculo na API.');
        }

        return redirect()->route('veiculos.index')->with('success', 'Veiculo criado com sucesso!');
    }


    
    public function show($id)
    {
        //
    }

    
    
    public function edit($id)
    {
        $response = Http::get("{$this->apiBaseUrl}/{$id}");

        if ($response->failed()) {
            return redirect()->route('veiculos.index')->with('error', 'Veiculo não encontrado na API.');
        }

        $veiculo = $response->json();

        return view('veiculos.edit', ['veiculo' => $veiculo]);
    }


    public function update(Request $request, $id)
    {
        $data = $request->only(['marca', 'modelo', 'placa', 'ano', 'cor']); 
        
        $response = Http::put("{$this->apiBaseUrl}/{$id}", $data);

        if ($response->failed()) {
            return back()->with('error', 'Falha ao atualizar o veiculo na API.');
        }

        return redirect()->route('veiculos.index')->with('success', 'Veiculo atualizado com sucesso!');
    }

 
    public function destroy($id)
    {
        $response = Http::delete("{$this->apiBaseUrl}/{$id}");

        if ($response->failed()) {
            return redirect()->back()->with('error', 'Falha ao excluir o veiculo na API.');
        }

        return redirect()->route('veiculos.index')->with('success', 'Veiculo excluído com sucesso!');
    }
}