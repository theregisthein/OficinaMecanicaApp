<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller{



    public function showLoginForm()
    {
        //variável $isHomePage é injetada APENAS na tela de login e dashboard
        $isHomePage = true; 
        
        return view('welcome', compact('isHomePage')); 
    }


    public function login(Request $request)
    {
        $email = $request->input('email');
        $senha = $request->input('senha');

        try {
            $baseUrl = env('JAVA_PROXY_URL');
            $response = Http::post($baseUrl . '/pessoas-proxy/login', [
                'email' => $email,
                'senha' => $senha,
                
            ]);
            if ($response->successful()) {
                
                $pessoa = $response->json();
                
                $request->session()->put('usuario', $pessoa);
                
                return redirect()->route('dashboard');

            } else {
                return back()->withInput()->with('error', 'Credenciais inválidas. Tente novamente.');
            }
        } catch (\Exception $e) {
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
        $request->session()->forget('usuario');
        $request->session()->flush();
        
        return redirect('/')->with('success', 'Você foi desconectado com sucesso!');
    }
}