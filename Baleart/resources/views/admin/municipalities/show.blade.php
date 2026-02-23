<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle del Municipio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="place-card pb-6 mb-6 last:border-b-0 last:mb-0">
                        <div class="flex justify-between items-start">
                            <div>
                                {{-- NOMBRE DEL MUNICIPIO --}}
                                <h3 class="text-xl font-bold text-gray-800 mb-2">
                                    {{ $municipality->name }}
                                </h3>
                                
                                {{-- ID --}}
                                <p class="text-sm mb-1">
                                    <span class="font-bold">ID Municipio:</span> 
                                    <span class="text-blue-600 font-semibold text-xs tracking-wide">
                                        #{{ $municipality->id }}
                                    </span>
                                </p>

                                {{-- ISLA --}}
                                <p class="text-sm mb-1">
                                    <span class="font-bold">Isla:</span> 
                                    <span>
                                        {{ $municipality->island->name ?? 'N/A' }}
                                    </span>
                                </p>

                                {{-- ZONA --}}
                                <p class="text-sm mb-1">
                                    <b class="text-black-700">Zona:</b> 
                                    <span class="text-black-600">
                                        {{ $municipality->zone->name ?? 'N/A' }}
                                    </span>
                                </p>

                                {{-- RECUENTO --}}
                                <p class="text-sm mb-1">
                                    <span class="font-bold">Rutas registradas:</span>
                                    <span class="text-black-600">{{ $municipality->treks->count() }}</span>
                                </p>

                                {{-- TIMESTAMPS --}}
                                <p class="mt-4 mb-1 text-sm">
                                    created at: {{ $municipality->created_at }}
                                </p>

                                <p class="mb-4 text-sm">
                                    updated at: {{ $municipality->updated_at }}
                                </p>
                            </div>
                        </div>

                        {{-- BOTONES DE ACCIÓN (IDÉNTICOS A TU EJEMPLO) --}}
                        <div class="flex justify-between items-center mt-4">
                            <div class="flex gap-2">
                                <a href="{{ route('municipalities.show', $municipality->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition text-sm">Ver</a>
                                <a href="{{ route('municipalities.edit', $municipality->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition text-sm">Editar</a>
                            </div>

                            <form action="{{ route('municipalities.destroy', $municipality->id) }}" method="POST" onsubmit="return confirm('¿Borrar este municipio?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition text-sm">Borrar</button>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>