<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Municipios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ================= BUSCADOR ================= --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h5 class="mb-4 text-xl font-medium leading-tight text-gray-800">
                        Buscar municipios
                    </h5>

                    <div class="flex flex-col md:flex-row md:items-end gap-4">
                        <div class="w-full md:max-w-md">
                            <input
                                type="text"
                                id="tableSearch"
                                placeholder="Buscar por nombre, isla, zona..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        </div>

                        <div id="searchCount"
                            class="text-sm text-gray-400 font-medium italic mb-2 md:mb-0">
                            Mostrando todos los municipios
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= LISTADO LISO SIN LÍNEAS ================= --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @forelse($municipalities as $municipality)
                        {{-- Eliminada la clase border-b --}}
                        <div class="place-card pb-4 mb-4">
                            <div class="p-2 text-surface">

                                {{-- TÍTULO (NOMBRE) --}}
                                <h5 class="mb-1 text-xl font-bold text-gray-800 leading-tight">
                                    {{ $municipality->name }}
                                </h5>

                                {{-- DATOS TÉCNICOS --}}
                                <div class="space-y-3 mb-4">
                                    <p class="text-sm">
                                        <b class="text-black-700">Isla:</b> 
                                        <span class="text-black-600">{{ $municipality->island->name }}</span>
                                    </p>

                                    <p class="text-sm">
                                        <b class="text-black-700">Zona:</b> 
                                        <span class="text-black-600">{{ $municipality->zone->name }}</span>
                                    </p>
                                </div>

                                {{-- FECHAS DE SISTEMA --}}
                                <p class="mb-2 text-sm">created at: {{ $municipality->created_at }}</p>
                                <p class="mb-4 text-sm">updated at: {{ $municipality->updated_at }}</p>

                                {{-- BOTONES DE ACCIÓN --}}
                                <div class="flex justify-between items-center">
                                    <div class="flex gap-2">
                                        <a href="{{ route('municipalities.show', $municipality->id) }}" 
                                           class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition text-sm">Ver</a>
                                        <a href="{{ route('municipalities.edit', $municipality->id) }}" 
                                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition text-sm">Editar</a>
                                    </div>

                                    <form action="{{ route('municipalities.destroy', $municipality->id) }}" method="POST" onsubmit="return confirm('¿Borrar este municipio?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition text-sm">Borrar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="py-4">No hay municipios registrados.</p>
                    @endforelse

                    {{-- Paginación --}}
                    <div class="mt-6">
                        {{ $municipalities->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
        const input = document.getElementById('tableSearch');
        const countDisplay = document.getElementById('searchCount');

        input.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.place-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const textToSearch = card.innerText.toLowerCase();
                if (textToSearch.includes(searchTerm)) {
                    card.style.display = "";
                    visibleCount++;
                } else {
                    card.style.display = "none";
                }
            });

            countDisplay.innerText = searchTerm === "" 
                ? "Mostrando todos los municipios" 
                : `Resultados encontrados: ${visibleCount}`;
        });
    </script>
</x-app-layout>