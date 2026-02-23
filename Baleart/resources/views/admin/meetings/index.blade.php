<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trobades') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ================= BUSCADOR ================= --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h5 class="mb-4 text-xl font-medium leading-tight text-gray-800">
                        Buscar trobadas
                    </h5>

                    <div class="flex flex-col md:flex-row md:items-end gap-4">
                        <div class="w-full md:max-w-md">
                            <input
                                type="text"
                                id="tableSearch"
                                placeholder="Buscar por excursión, guía, ID o fecha..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        </div>

                        <div id="searchCount"
                            class="text-sm text-gray-400 font-medium italic mb-2 md:mb-0">
                            Mostrando todas las trobadas
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= LISTADO ================= --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

            
                    @forelse($meetings as $meeting)
                        @include('components.card-meetings', ['meeting' => $meeting])
                    @empty
                        <p class="text-gray-500 italic text-center py-4">No hay trobadas programadas.</p>
                    @endforelse

                    {{-- Paginación --}}
                    <div class="mt-6">
                        {{ $meetings->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- Script de búsqueda: Idéntico al de lugares para mantener la coherencia --}}
    <script>
        const input = document.getElementById('tableSearch');
        const countDisplay = document.getElementById('searchCount');

        input.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.place-card'); // Usamos la misma clase que en la card

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
                countDisplay.innerText = "Mostrando todas las trobadas";
            } else {
                countDisplay.innerText = `Resultados encontrados: ${visibleCount}`;
            }
        });
    </script>

</x-app-layout>