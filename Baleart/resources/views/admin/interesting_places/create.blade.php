<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuevo Lugar de Interés') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('interesting-places.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            {{-- NOMBRE --}}
                            <div>
                                <label class="block mb-2 font-bold text-gray-700">Nombre del Lugar</label>
                                <input type="text" name="name" value="{{ old('name') }}" 
                                    class="w-full border-gray-300 rounded shadow-sm text-sm @error('name') border-red-500 @enderror"
                                    placeholder="Ej: Torrent de Pareis">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- TIPO DE LUGAR --}}
                            <div>
                                <label class="block mb-2 font-bold text-gray-700">Tipo de Lugar</label>
                                <select name="place_type_id" class="w-full border-gray-300 rounded shadow-sm text-sm @error('place_type_id') border-red-500 @enderror">
                                    <option value="">-- Seleccionar Tipo --</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}" {{ old('place_type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('place_type_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- GPS --}}
                        <div class="mb-8">
                            <label class="block mb-2 font-bold text-gray-700">Coordenadas GPS</label>
                            <input type="text" name="gps" value="{{ old('gps') }}" 
                                class="w-full border-gray-300 rounded shadow-sm text-sm @error('gps') border-red-500 @enderror"
                                placeholder="Ej: 39.8189, 2.7275">
                            @error('gps')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-6 border-t border-gray-100 flex items-center justify-between">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition duration-200">
                                GUARDAR LUGAR
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>