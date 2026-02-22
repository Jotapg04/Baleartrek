<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Lugar Remarcable') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- BLOQUE DE ERRORES: Esto nos dirá por qué no guarda --}}
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 shadow-sm rounded">
                    <p class="font-bold">Por favor, corrige los siguientes errores:</p>
                    <ul class="list-disc pl-5 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('interesting-places.update', $place->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- NOMBRE --}}
                        <div class="mb-6">
                            <label for="name" class="block mb-2 font-semibold text-gray-700">Nombre del Lugar</label>
                            <input type="text" id="name" name="name" autocomplete="name"
                                value="{{ old('name', $place->name) }}"
                                class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                        </div>

                        {{-- TIPO DE LUGAR --}}
                        <div class="mb-6">
                            <label for="place_type_id" class="block mb-2 font-semibold text-gray-700">Tipo de Lugar</label>
                            <select id="place_type_id" name="place_type_id" 
                                class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                                <option value="">Selecciona un tipo...</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" 
                                        {{ old('place_type_id', $place->place_type_id) == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        {{-- GPS --}}
                        <div class="mb-6">
                            <label for="gps" class="block mb-2 font-semibold text-gray-700">Coordenadas GPS</label>
                            <input 
                                type="text" 
                                id="gps" 
                                name="gps" {{-- Nombre real de la columna --}}
                                value="{{ old('gps', $place->gps) }}" {{-- Ahora recupera de la columna 'gps' --}}
                                class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 shadow-sm font-mono text-red-600"
                            >
                            @error('gps')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition shadow-sm">
                                ACTUALIZAR
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('interesting-places.index') }}" class="text-blue-600 hover:text-blue-900 transition font-medium">
                    &larr; Volver al listado de lugares
                </a>
            </div>
        </div>
    </div>
</x-app-layout>