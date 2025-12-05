<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class RelatorioController extends Controller
{
    // Chama o Proxy (8080)
    private $apiUrl = 'http://localhost:8080/ia-proxy/gerar';

    public function index()
    {
        // Retorna a view vazia inicialmente
        return view('relatorios.ia', ['relatorio' => null]);
    }

    public function gerar()
    {
        try {
            // Chama o Java (que chama a OpenAI)
            // Aumentamos o timeout para 60 segundos porque a IA demora a pensar
            $response = Http::timeout(60)->post($this->apiUrl);

            if ($response->failed()) {
                return back()->with('error', 'Falha ao conectar com a IA: ' . $response->body());
            }

            // Pega o texto que a IA respondeu
            $textoRelatorio = $response->body();

            return view('relatorios.ia', ['relatorio' => $textoRelatorio]);

        } catch (\Exception $e) {
            return back()->with('error', 'Erro técnico: ' . $e->getMessage());
        }
    }
}