<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Excursión : {{ $trek->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form action="{{ route('treks.update',$trek->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <label class="block mb-2 font-semibold">Nombre</label>
                        <input type="text" name="name"
                            value="{{ old('name',$trek->name) }}"
                            class="w-full mb-6 border-gray-300 rounded">

                        <label class="block mb-2 font-semibold">Municipio</label>
                        <select name="municipality_id" class="w-full mb-6 border-gray-300 rounded">
                            @foreach($municipalities as $municipality)
                            <option value="{{ $municipality->id }}"
                                {{ $trek->municipality_id==$municipality->id?'selected':'' }}>
                                {{ $municipality->name }}
                            </option>
                            @endforeach
                        </select>

                        <label class="block mb-2 font-semibold">Estado</label>
                        <select name="status" class="w-full mb-6 border-gray-300 rounded">
                            <option value="y" {{ $trek->status=='y'?'selected':'' }}>Activo</option>
                            <option value="n" {{ $trek->status=='n'?'selected':'' }}>Inactivo</option>
                        </select>

                        <label class="block mt-6 mb-2 font-semibold">
                            Lugares remarcables
                        </label>

                        <div class="grid grid-cols-2 gap-4">

                            @foreach($interestingPlaces as $place)

                            <label class="flex items-center gap-2 border rounded p-3">

                                <input type="checkbox"
                                    name="interesting_places[]"
                                    value="{{ $place->id }}"

                                    {{-- EDIT → marcar existentes --}}
                                    @if(isset($trek) && $trek->interestingPlaces->contains($place->id))
                                checked
                                @endif
                                >

                                {{ $place->name }}

                            </label>

                            @endforeach

                        </div>

                        <button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded gap-2 mt-6">
                            ACTUALIZAR
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>

</x-app-layout>