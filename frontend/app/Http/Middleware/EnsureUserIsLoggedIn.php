<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // se a sessão usuario nao existir (usuário não logado)
        if (!$request->session()->has('usuario')) {
            // redireciona para a tela de login
            return redirect('/')->with('error', 'Você precisa estar logado para acessar esta área.');
        }

        // re a sessão existir continua com a requisição
        return $next($request);
    }
}