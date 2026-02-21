<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listado de Excursiones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- BUSCADOR (Igual que en Usuarios) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Filtrar Catálogo de Rutas</h3>
                    <div class="flex flex-col md:flex-row md:items-end gap-4">
                        <div class="w-full md:max-w-md">
                            <label class="text-xs font-bold text-gray-500 uppercase mb-1 block">Término de búsqueda</label>
                            <input type="text" id="tableSearch" placeholder="Buscar por nombre, municipio..."
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        </div>
                        <div id="searchCount" class="text-sm text-gray-400 italic">
                            Mostrando todas las excursiones
                        </div>
                    </div>
                </div>
            </div>

            {{-- LISTADO VERTICAL --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div id="trekContainer">
                        @each('components.card-treks', $treks, 'trek')
                    </div>

                    <div class="mt-6">
                        {{ $treks->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- SCRIPT (El mismo que en Usuarios) --}}
    <script>
        const input = document.getElementById('tableSearch');
        const countDisplay = document.getElementById('searchCount');

        input.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.trek-card');
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
                ? "Mostrando todas las excursiones" 
                : `Resultados encontrados: ${visibleCount}`;
        });
    </script>
</x-app-layout>