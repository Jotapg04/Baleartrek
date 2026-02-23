<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle del Comentario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="comment-card pb-6 mb-6 last:border-b-0 last:mb-0">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Comentario #{{ $comment->id }}</h3>
                                
                                <p class="text-sm text-black-700 mb-1">
                                    <span class="font-bold">Autor:</span> {{ $comment->user->name }} {{ $comment->user->lastName }} ({{ $comment->user->email }})
                                </p>
                                
                                <p class="text-sm text-black-700 mb-1">
                                    <span class="font-bold">Excursión:</span> {{ $comment->meeting->trek->name }}
                                </p>

                                <p class="text-sm text-black-700 mb-1">
                                    <span class="font-bold">Contenido:</span> 
                                    <span class="px-2 py-0.5 rounded">
                                        {{ $comment->comment }}
                                    </span>
                                </p>
                                
                                <p class="mb-2 text-sm">
                                    <b>Estado:</b>
                                    @if($comment->status === 'y')
                                        <span class="text-green-600 font-semibold">Activo</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Oculto</span>
                                    @endif
                                </p>

                                <p class="mb-2 text-sm">
                                    created at: {{ $comment->created_at }}
                                </p>

                                <p class="mb-4 text-sm">
                                    updated at: {{ $comment->updated_at }}
                                </p>

                                @if($comment->images->count() > 0)
                                    <div class="flex flex-wrap gap-2 md:w-1/3 justify-start">
                                        @foreach($comment->images as $image)
                                            @php
                                                $placeholderUrl = "https://loremflickr.com/400/400/mountain,trekking?lock=" . $image->id;
                                            @endphp
                                            <div class="relative group">
                                                <img src="{{ $placeholderUrl }}" 
                                                    alt="Imagen de {{ $comment->user->name }}" 
                                                    class="w-20 h-20 object-cover rounded-lg shadow-sm transition group-hover:scale-105">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-4">
                            <div class="flex gap-2">
                                <a href="{{ route('comments.index') }}" 
                                   class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Ver
                                </a>
                                <a href="{{ route('comments.edit', $comment->id) }}" 
                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Editar
                                </a>
                            </div>

                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este comentario?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Borrar
                                </button>
                            </form>                     
                        </div>
                        
                    </div>
                    
                    </div>
                    
            </div>
        </div>
    </div>
</x-app-layout>