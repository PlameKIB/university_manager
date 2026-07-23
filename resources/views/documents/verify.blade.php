<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification de document — {{ config('app.name') }}</title>
    {{-- Assets compilés localement (Tailwind + FontAwesome) : la vérification
         doit fonctionner même sans accès internet, le système tournant en réseau local --}}
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-lg w-full">

        <div class="text-center mb-6">
            <h1 class="text-xl font-bold text-gray-800">{{ config('app.name') }}</h1>
            <p class="text-sm text-gray-500">Portail de vérification d'authenticité des documents</p>
        </div>

        <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">

            @if(!$document)

                <div class="p-8 text-center">
                    <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-triangle-exclamation text-red-600 text-2xl"></i>
                    </div>
                    <h2 class="text-lg font-bold text-red-600">Document introuvable</h2>
                    <p class="text-sm text-gray-500 mt-2">
                        Aucun document ne correspond à ce code. Il peut s'agir d'une falsification
                        ou d'une erreur de saisie du code.
                    </p>
                </div>

            @elseif($document->is_revoked)

                <div class="p-8 text-center">
                    <div class="w-16 h-16 rounded-full bg-amber-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-ban text-amber-600 text-2xl"></i>
                    </div>
                    <h2 class="text-lg font-bold text-amber-600">Document révoqué</h2>
                    <p class="text-sm text-gray-500 mt-2">
                        Ce document a été annulé par l'institution émettrice
                        @if($document->revoked_reason)
                            &nbsp;: {{ $document->revoked_reason }}
                        @endif
                        . Il ne doit plus être considéré comme valide.
                    </p>
                </div>

            @else

                <div class="p-8 text-center border-b border-gray-100">
                    <div class="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-2xl"></i>
                    </div>
                    <h2 class="text-lg font-bold text-emerald-600">Document authentique</h2>
                    <p class="text-sm text-gray-500 mt-2">
                        Ce document a bien été émis par {{ config('app.name') }} et n'a pas été altéré.
                    </p>
                </div>

                <div class="p-6 space-y-3">

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Type de document</span>
                        <span class="font-semibold text-gray-800">{{ $document->typeLabel() }}</span>
                    </div>

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Code de vérification</span>
                        <span class="font-semibold text-indigo-600">{{ $document->code }}</span>
                    </div>

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Émis le</span>
                        <span class="font-semibold text-gray-800">{{ $document->created_at->translatedFormat('d F Y à H:i') }}</span>
                    </div>

                    @if($document->generatedBy)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Émis par</span>
                            <span class="font-semibold text-gray-800">{{ $document->generatedBy->name }}</span>
                        </div>
                    @endif

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Empreinte numérique</span>
                        <span class="font-mono text-xs text-gray-400">{{ substr($document->hash, 0, 24) }}...</span>
                    </div>

                    @if(!empty($document->payload))
                        <div class="pt-3 mt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-400 uppercase font-semibold mb-2">Informations liées</p>
                            @foreach($document->payload as $key => $value)
                                @if(!is_array($value) && !is_null($value))
                                    <div class="flex justify-between text-sm py-1">
                                        <span class="text-gray-500">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                                        <span class="font-medium text-gray-700">{{ $value }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                </div>

            @endif

        </div>

        <p class="text-center text-xs text-gray-400 mt-6">
            Vérification propulsée par le système de gestion académique — {{ config('app.name') }}
        </p>

    </div>

</body>
</html>
