<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Lugares Remarcables') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ================= BUSCADOR (Contenedor Separado) ================= --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h5 class="mb-4 text-xl font-medium leading-tight text-gray-800">
                        Buscar lugares
                    </h5>

                    <div class="flex flex-col md:flex-row md:items-end gap-4">
                        <div class="w-full md:max-w-md">
                            <input
                                type="text"
                                id="tableSearch"
                                placeholder="Buscar por nombre, tipo o GPS..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        </div>

                        <div id="searchCount"
                            class="text-sm text-gray-400 font-medium italic mb-2 md:mb-0">
                            Mostrando todos los lugares
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= LISTADO (Contenedor Separado) ================= --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @foreach($interestingPlaces as $place)
                        @include('components.card-interestingPlaces', ['place' => $place])
                    @endforeach

                    <div class="mt-6">
                        {{ $interestingPlaces->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- Script de búsqueda sin cambios ya que funciona perfectamente --}}
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

            if (searchTerm === "") {
                countDisplay.innerText = "Mostrando todos los lugares";
                countDisplay.classList.remove('text-indigo-600');
            } else {
                countDisplay.innerText = `Resultados encontrados: ${visibleCount}`;
            }
        });
    </script>

</x-app-layout>