<!DOCTYPE html>
<html>

<head>
    <title>@yield('titulo')</title>
</head>

<body>
    <header>
      @include('plantillas.navbar')
        <h1>Mi Sitio Web</h1>
    </header>
    <main>
        @yield('contenido')
      
    </main>
    <footer>
        <p>© 2025 Mi Sitio Web</p>
    </footer>
</body>

</html>