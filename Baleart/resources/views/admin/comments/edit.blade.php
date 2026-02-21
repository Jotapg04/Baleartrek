<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Comentario de: {{ $comment->user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-8">

                    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- CONTENIDO DEL COMENTARIO --}}
                        <div class="mb-6">
                            <label class="block mb-2 font-semibold text-gray-700">Contenido del Comentario</label>
                            <textarea name="content" rows="4" 
                                      class="w-full border-gray-300 rounded shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('content', $comment->content) }}</textarea>
                        </div>

                        {{-- BOTÓN --}}
                        <div class="flex items-center pt-4">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded shadow transition">
                                ACTUALIZAR COMENTARIO
                            </button>
                            <a href="{{ route('comments.index') }}" class="ml-4 text-gray-500 hover:underline text-sm">
                                Cancelar
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>