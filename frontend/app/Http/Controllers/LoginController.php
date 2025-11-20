<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller{

    public function showLoginForm()
    {
        //variável $isHomePage é injetada APENAS na tela de login e dashboard
        $isHomePage = true; 
        
        //Laravel vai renderizar o layout com as classes de centralização
        return view('welcome', compact('isHomePage')); 
    }


    public function login(Request $request)
    {
        $email = $request->input('email');
        $senha = $request->input('senha');

        // tenta autenticar contra o Proxy Java (8080)
        try {
            $response = Http::post('http://localhost:8080/pessoas-proxy/login', [
                'email' => $email,
                'senha' => $senha,
            ]);

            // se a API retornar 200 Login OK
            if ($response->successful()) {
                $pessoa = $response->json();
                
                // cria a sessão do Laravel com os dados do usuário
                $request->session()->put('usuario', $pessoa);
                
                return redirect()->route('dashboard');

            } else {
                // se a API retornar 401 (Não Autorizado) ou qualquer outro erro
                // o back() serve para voltar para a tela de login com a mensagem de erro
                return back()->withInput()->with('error', 'Credenciais inválidas. Tente novamente.');
            }
        } catch (\Exception $e) {
            // se o Proxy Java não estiver rodando ou ter erro de conexão
            return back()->withInput()->with('error', 'Serviço de autenticação indisponível. Por favor, tente mais tarde.');
        }
    }


    public function dashboard(Request $request)
    {
        //variável $isHomePage é injetada no dashboard para o layout saber o fundo
        $isHomePage = true; 
        
        // se o middleware não bloqueou, o usuário está logado
        return view('dashboard', compact('isHomePage'));
    }


    public function logout(Request $request)
    {
        // remove todos os dados da sessão
        $request->session()->forget('usuario');
        $request->session()->flush();
        
        return redirect('/')->with('success', 'Você foi desconectado com sucesso!');
    }
}