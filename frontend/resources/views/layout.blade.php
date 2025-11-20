<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Oficina Mecânica</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        html, body {
            height: 100%;
            width: 100%;
            margin: 0; 
            padding: 0;
        }
        
        body {
            padding-top: @if (session()->has('usuario')) 56px @else 0 @endif; 
        }

        /* CSS CUSTOMIZADO PARA A HOME / LOGIN */
        @if (isset($isHomePage) && $isHomePage)
        body {
            background-image: url('{{ asset('Imagens/oficina_background.jpg') }}'); 
            background-size: cover; 
            background-position: center;
            
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-height: 100vh;
        }
        .home-main-content {
            padding: 0 !important;
            max-width: 100% !important;
            background: none; 
        }
        @endif
    </style>
    @stack('styles')
</head>

<body>

    {{-- NAV BAR MOVIDA PARA FORA DO <main> E FIXADA NO TOPO --}}
    @if (session()->has('usuario'))
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}"><strong>Oficina (Dashboard)</strong></a> 
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('ordens.index') }}">Ordens de Serviço</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pessoas.index') }}">Pessoas</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('veiculos.index') }}">Veículos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('itens.index') }}">Itens</a></li>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link btn btn-sm btn-outline-danger" href="{{ route('logout') }}">Sair ({{ session('usuario')['nome'] }})</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @endif


    {{-- 2. O <main> é o container principal para o conteúdo --}}
    <main class="@if (isset($isHomePage) && $isHomePage) home-main-content @else container py-4 @endif">
        
        {{-- Bloco de Alertas (Mantém a lógica) --}}
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <strong>Erros:</strong>
                <ul>
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @yield('content')
        
    </main>
    
    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>