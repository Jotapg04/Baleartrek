<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Comentario de: {{ $comment->user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <label class="block mb-2 font-semibold">Contenido del Comentario</label>
                        <div class="w-full mb-6 p-3 bg-gray-50 border border-gray-200 rounded text-gray-600 italic">
                            "{{ $comment->comment }}"
                        </div>

                        <label class="block mb-2 font-semibold">Estado</label>
                        <select name="status" class="w-full mb-6 border-gray-300 rounded">
                            <option value="y" {{ $comment->status == 'y' ? 'selected' : '' }}>Activo</option>
                            <option value="n" {{ $comment->status == 'n' ? 'selected' : '' }}>Oculto</option>
                        </select>

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