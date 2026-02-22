<div class="place-card pb-4">
    <div class="p-2 text-surface">

        {{-- NOMBRE Y TIPO DE LUGAR --}}
        <h5 class="mb-1 text-xl font-bold text-gray-800 leading-tight">
            {{ $place->name }}
        </h5>
        <p class="text-sm text-gray-700 mb-1">
            <span class="font-bold">Tipo:</span> 
            <span class="text-blue-600 uppercase font-semibold text-xs tracking-wide">
                {{ $place->type->name }}
            </span>
        </p>

        {{-- DATOS TÉCNICOS --}}
        <div class="space-y-3 mb-4">
            <p class="text-sm flex items-center gap-2">
                <b class="text-gray-700">Coordenadas GPS:</b> 
                <code class="px-2 py-1 rounded text-xs text-gray-800">
                    {{ $place->gps }}
                </code>
            </p>
        </div>

       <p class="mb-2 text-sm">
                created at: {{ $place->created_at }}
            </p>

            <p class="mb-4 text-sm">
                updated at: {{ $place->updated_at }}
            </p>

        {{-- BOTONES DE ACCIÓN --}}
        <div class="flex justify-between items-center mt-4">
            <div class="flex gap-2">
                <a href="{{ route('interesting-places.show', $place->id) }}" 
                   class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition text-sm">
                    Show
                </a>
                <a href="{{ route('interesting-places.edit', $place->id) }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition text-sm">
                    Edit
                </a>
            </div>

            <form action="{{ route('interesting-places.destroy', $place->id) }}" method="POST" onsubmit="return confirm('¿Borrar este lugar?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition text-sm">
                    Delete
                </button>
            </form>
        </div>

    </div>
</div>