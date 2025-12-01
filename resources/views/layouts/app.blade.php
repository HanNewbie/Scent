<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @stack('styles')
</head>

<body>
    @yield('navbar')
    <main class="flex-1">
        @yield('content')
    </main>
</body>
</html>
