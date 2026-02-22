<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle del Lugar Remarcable') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="place-card pb-6 mb-6 last:border-b-0 last:mb-0">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">
                                    {{ $place->name }}
                                </h3>
                                
                                <p class="text-sm text-gray-700 mb-1">
                                    <span class="font-bold">Tipo:</span> 
                                    <span class="text-blue-600 uppercase font-semibold text-xs tracking-wide">
                                        {{ $place->type->name }}
                                    </span>
                                </p>
                                
                                <p class="text-sm text-gray-700 mb-1">
                                    <span class="font-bold">Coordenadas GPS:</span> 
                                    <code class="px-2 py-0.5 rounded font-mono text-xs">
                                        {{ $place->gps }}
                                    </code>
                                </p>

                                <p class="mt-4 mb-1 text-sm italic">
                                    created at: {{ $place->created_at }}
                                </p>

                                <p class="mb-4 text-sm italic">
                                    updated at: {{ $place->updated_at }}
                                </p>
                            </div>
                        </div>

                        
                    </div>
                    
                </div>
            </div>

            {{-- ENLACE DE RETORNO EXTERNO --}}
            <div class="mt-4">
                <a href="{{ route('interesting-places.index') }}" class="text-blue-600 hover:text-blue-900 transition font-medium">
                    &larr; Volver al listado de lugares
                </a>
            </div>
        </div>
    </div>
</x-app-layout>