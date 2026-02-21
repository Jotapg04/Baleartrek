<div class="place-card bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
    <div class="p-6 text-surface">

        {{-- NOMBRE Y TIPO DE LUGAR --}}
        <h5 class="mb-1 text-xl font-medium leading-tight">
            {{ $place->name }}
        </h5>
        <p class="mb-4 text-xs font-bold text-blue-600 uppercase tracking-wide">
            {{ $place->type->name }} {{-- Relación definida en tu modelo --}}
        </p>

        {{-- DATOS TÉCNICOS --}}
        <div class="space-y-3 mb-6">
            <p class="text-sm flex items-center gap-2">
                <b class="text-gray-700">Coordenadas GPS:</b> 
                <code class="bg-gray-100 px-2 py-1 rounded text-red-600 text-xs">
                    {{ $place->gps }}
                </code>
            </p>

            <p class="text-sm">
                <b class="text-gray-700">Aparece en:</b> 
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                    {{ $place->treks->count() }} excursiones
                </span>
            </p>
        </div>

        {{-- ENLACE EXTERNO A MAPA (Opcional pero recomendado en rúbrica) --}}
        <div class="mb-6">
            <a href="https://www.google.com/maps/search/?api=1&query={{ $place->gps }}" 
               target="_blank" 
               class="text-xs text-blue-500 hover:underline flex items-center gap-1">
                Ver ubicación en el mapa
            </a>
        </div>

        {{-- BOTONES DE ACCIÓN (CRUD ADMIN) --}}
        <div class="flex items-center justify-between border-t pt-4">
            <div class="flex gap-x-2">
                <a href="{{ route('interesting-places.show', $place->id) }}"
                    class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-2 px-3 rounded transition shadow-sm">
                    Ver
                </a>

                <a href="{{ route('interesting-places.edit', $place->id) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 px-3 rounded transition shadow-sm">
                    Editar
                </a>
            </div>

            <form action="{{ route('interesting-places.destroy', $place->id) }}" 
                  method="POST" 
                  onsubmit="return confirm('¿Borrar este lugar remarcable?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold py-2 px-3 rounded transition shadow-sm">
                    Eliminar
                </button>
            </form>
        </div>

    </div>
</div>