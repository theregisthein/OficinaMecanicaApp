<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Oficina Mecânica</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>
<body class="container">

    <div class="container">
    
        {{-- Bloco de Alertas --}}
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

  <nav>
    <ul>
     
      <li><a href="{{ route('itens.index') }}">Itens</a></li>
    </ul>
  </nav>

  @if(session('ok'))
    <article>{{ session('ok') }}</article>
  @endif

  @if ($errors->any())
    <article>
      <strong>Erros:</strong>
      <ul>
        @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </article>
  @endif

  <main>@yield('content')</main>

</body>
</html>