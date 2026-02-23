<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Comentarios
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            
            {{-- ================= BUSCADOR Y FILTROS ================= --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h5 class="mb-4 text-xl font-medium leading-tight text-gray-800">
                        Buscar comentarios
                    </h5>

                    <div class="flex flex-col md:flex-row md:items-end gap-4">
                        {{-- Búsqueda por Texto (JavaScript Instantáneo) --}}
                        <div class="w-full md:max-w-md">
                            <input
                                type="text"
                                id="commentSearch"
                                placeholder="Escribe para filtrar..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        </div>

                        {{-- Filtros de Estado con lógica de alternancia --}}
                        <div class="flex gap-2">
                            <a href="{{ request('status') === 'y' ? route('comments.index') : route('comments.index', ['status' => 'y']) }}" 
                               class="px-3 py-2 text-xs font-semibold rounded-lg border transition {{ request('status') === 'y' ? 'bg-green-500 text-white border-green-500' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
                                Aprobados
                            </a>

                            <a href="{{ request('status') === 'n' ? route('comments.index') : route('comments.index', ['status' => 'n']) }}" 
                               class="px-3 py-2 text-xs font-semibold rounded-lg border transition {{ request('status') === 'n' ? 'bg-red-500 text-white border-red-500' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
                                Ocultos
                            </a>
                        </div>

                        <div id="commentCount" class="text-sm text-gray-400 font-medium italic mb-2 md:mb-0">
                            Mostrando todos los comentarios
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= LISTADO ================= --}}
            <div id="commentsList" class="space-y-4">
                @foreach($comments as $comment)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg comment-card">
                        <div class="p-6 text-gray-900">
                            <div class="flex flex-col md:flex-row justify-between gap-6">
                                <div class="flex-1">
                                    <div class="flex items-center gap-4 mb-2">
                                        <h3 class="text-xl font-bold">
                                            {{ $comment->user->name }} {{ $comment->user->lastName }}
                                        </h3>
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-bold flex items-center gap-1">
                                            ★ {{ $comment->score }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-sm mb-1"><span class="font-bold">Excursión:</span> {{ $comment->meeting->trek->name }}</p>
                                    <p class="text-sm mb-2"><span class="font-bold">Comentario:</span> "{{ $comment->comment }}"</p>

                                    <p class="text-sm mb-4">
                                        <span class="font-bold">Estado:</span> 
                                        @if($comment->status === 'y')
                                            <span class="text-green-600 font-semibold">Aprobado</span>
                                        @else
                                            <span class="text-red-600 font-semibold">Oculto</span>
                                        @endif
                                    </p>

                                    {{-- Fechas en color NEGRO --}}
                                    <div class="text-xs text-black">
                                        <p>created at: {{ $comment->created_at }}</p>
                                        <p>updated at: {{ $comment->updated_at }}</p>
                                    </div>

                                    @if($comment->images->count() > 0)
                                        <div class="mt-2 p-2">
                                            <div class="flex flex-col gap-2">
                                                @foreach($comment->images as $image)
                                                    <div class="text-sm text-black"> 
                                                        <span class="font-bold">Imagen adjunta:</span>
                                                        <a href="{{ $image->url }}" target="_blank" class="text-blue-500 hover:underline ml-1">
                                                            {{ $image->url }}
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-100">
                                <div class="flex gap-2">
                                    <a href="{{ route('comments.show', $comment->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition">Ver</a>
                                    <a href="{{ route('comments.edit', $comment->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">Editar</a>
                                </div>
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres borrar este comentario?')">
                                    @csrf @method('DELETE')
                                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition">Borrar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $comments->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('commentSearch');
            const countDisplay = document.getElementById('commentCount');
            const cards = document.querySelectorAll('.comment-card');

            input.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase().trim();
                let visibleCount = 0;

                cards.forEach(card => {
                    const text = card.innerText.toLowerCase();
                    if (text.includes(searchTerm)) {
                        card.style.display = "";
                        visibleCount++;
                    } else {
                        card.style.display = "none";
                    }
                });

                countDisplay.innerText = searchTerm === "" 
                    ? "Mostrando todos los comentarios" 
                    : `Resultados encontrados: ${visibleCount}`;
            });
        });
    </script>
</x-app-layout>