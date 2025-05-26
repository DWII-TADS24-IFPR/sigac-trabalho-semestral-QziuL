<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIGAC</title>
</head>
<body>
    <div class="w-20 h-20 fill-current " style="width: 20rem; text-align: center; margin: auto">
        <div class="mt-4">
            <h1 class="block font-bold text-black dark:text-gray-300">Bem vindo ao SIGAC</h1>
        </div>
    </div>
</body>
</html>
