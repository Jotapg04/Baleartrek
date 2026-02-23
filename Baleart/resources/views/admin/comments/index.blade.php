<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Comentarios
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            
            @foreach($comments as $comment)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex flex-col md:flex-row justify-between gap-6">
                            
                            {{-- INFORMACIÓN DEL TEXTO --}}
                            <div class="flex-1">
                                <div class="flex items-center gap-4 mb-2">
                                    <h3 class="text-xl font-bold text-gray-800">
                                        {{ $comment->user->name }} {{ $comment->user->lastName }}
                                    </h3>
                                    {{-- SCORE / PUNTUACIÓN --}}
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-bold flex items-center gap-1">
                                        ★ {{ $comment->score }}
                                    </span>
                                </div>
                                
                                <p class="text-sm text-gray-700 mb-1">
                                    <span class="font-bold">Excursión:</span> {{ $comment->meeting->trek->name }}
                                </p>
                                
                                <p class="text-sm text-gray-700 mb-2 italic">
                                    <span class="font-bold not-italic">Comentario:</span> "{{ $comment->comment }}"
                                </p>

                                {{-- ESTADO (Dinamismo y/n) --}}
                                <p class="text-sm mb-4">
                                    <span class="font-bold">Estado:</span> 
                                    @if($comment->status === 'y')
                                        <span class="text-green-600 font-semibold">Aprobado</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Oculto</span>
                                    @endif
                                </p>

                                <div class="text-xs">
                                    <p>created at: {{ $comment->created_at }}</p>
                                    <p>updated at: {{ $comment->updated_at }}</p>
                                </div>

                                @if($comment->images->count() > 0)
                                    <div class="mt-2 p-2">
                                        <div class="flex flex-col gap-2"> {{-- Contenedor para separar cada bloque de imagen --}}
                                            @foreach($comment->images as $image)
                                                <div class="text-sm"> 
                                                    <span class="font-bold">Imagen adjunta:</span>
                                                    <a href="{{ $image->url }}" target="_blank" class="text-blue-500 hover:underline break-all ml-1">
                                                        {{ $image->url }}
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>

                        {{-- ACCIONES --}}
                        <div class="flex justify-between items-center mt-6 pt-4 ">
                            <div class="flex gap-2">
                                <a href="{{ route('comments.show', $comment->id) }}" 
                                   class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition">
                                    Show
                                </a>
                                <a href="{{ route('comments.edit', $comment->id) }}" 
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                                    Edit
                                </a>
                            </div>

                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('¿Seguro que quieres ocultar este comentario?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="mt-4">
                {{ $comments->links() }}
            </div>
        </div>
    </div>
</x-app-layout>