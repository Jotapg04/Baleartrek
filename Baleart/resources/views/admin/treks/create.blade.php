<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Excursión') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('treks.store') }}" method="POST">
                    @csrf

                    <label class="block mb-2 font-semibold">Nombre de la Excursión</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full mb-6 border-gray-300 rounded focus:ring-blue-500">

                    <label class="block mb-2 font-semibold">Municipio</label>
                    <select name="municipality_id" class="w-full mb-6 border-gray-300 rounded">
                        @foreach($municipalities as $municipality)
                            <option value="{{ $municipality->id }}">{{ $municipality->name }}</option>
                        @endforeach
                    </select>

                    <label class="block mb-2 font-semibold">Estado</label>
                    <select name="status" class="w-full mb-6 border-gray-300 rounded">
                        <option value="y" {{ old('status') == 'y' ? 'selected' : '' }}>Activo</option>
                        <option value="n" {{ old('status') == 'n' ? 'selected' : '' }}>Inactivo</option>
                    </select>

                    <label class="block mt-6 mb-2 font-semibold">Lugares remarcables</label>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($interestingPlaces as $place)
                            <label class="flex items-center gap-2 border rounded p-3 cursor-pointer hover:bg-gray-50">
                                <input type="checkbox" name="interesting_places[]" value="{{ $place->id }}"
                                    {{ is_array(old('interesting_places')) && in_array($place->id, old('interesting_places')) ? 'checked' : '' }}>
                                {{ $place->name }}
                            </label>
                        @endforeach
                    </div>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded mt-8 transition">
                        CREAR EXCURSIÓN
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>