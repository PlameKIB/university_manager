<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document non disponible — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-md border border-gray-100 p-8 text-center">

        <div class="w-16 h-16 rounded-full bg-amber-100 flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-circle-exclamation text-amber-600 text-2xl"></i>
        </div>

        <h1 class="text-lg font-bold text-gray-800">Document non disponible</h1>
        <p class="text-sm text-gray-500 mt-2">{{ $message }}</p>

        <button onclick="window.close()"
            class="mt-6 inline-flex items-center gap-2 px-4 py-2 bg-gray-800 hover:bg-gray-900
                   text-white rounded-xl font-semibold text-sm transition">
            Fermer cet onglet
        </button>

    </div>

</body>
</html>
