<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle del Comentario #{{ $comment->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Autor</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $comment->user->name }} ({{ $comment->user->email }})</p>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Excursión Relacionada</label>
                        <p class="text-lg text-gray-800">{{ $comment->meeting->trek->name }}</p>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Contenido</label>
                        <div class="bg-gray-50 p-4 rounded border border-gray-100 italic text-gray-700">
                            "{{ $comment->comment }}"
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Fecha de creación</label>
                            <p class="text-sm text-gray-600">{{ $comment->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Última actualización</label>
                            <p class="text-sm text-gray-600">{{ $comment->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-6 border-t border-gray-100">
                        <a href="{{ route('comments.edit', $comment->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition">
                            Editar
                        </a>
                        <a href="{{ route('comments.index') }}" class="text-gray-500 hover:text-gray-800 text-sm font-bold uppercase tracking-widest underline decoration-2 underline-offset-4">
                            Volver al listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>