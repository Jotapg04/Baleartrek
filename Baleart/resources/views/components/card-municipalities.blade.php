<div class="municipality-card bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
    <div class="p-6 text-surface">

        {{-- NOMBRE DEL MUNICIPIO --}}
        <h5 class="mb-4 text-xl font-medium leading-tight">
            {{ $municipality->name }}
        </h5>

        {{-- DATOS GEOGRÁFICOS --}}
        <p class="mb-2 text-sm">
            <b class="text-gray-700">Isla:</b> {{ $municipality->island->name }}
        </p>

        <p class="mb-2 text-sm">
            <b class="text-gray-700">Zona:</b> {{ $municipality->zone->name }}
        </p>


        {{-- FECHAS DE CONTROL --}}
        <div class="mt-4 pt-4 border-t border-gray-100">
            <p class="text-xs text-gray-400">
                Creado: {{ $municipality->created_at->format('d/m/Y') }}
            </p>
            <p class="text-xs text-gray-400">
                Última edición: {{ $municipality->updated_at->diffForHumans() }}
            </p>
        </div>

        {{-- BOTONES DE ACCIÓN (CRUD BACK OFFICE) --}}
        <div class="flex items-center justify-between mt-6">
            <div class="flex gap-x-2">
                <a href="{{ route('municipalities.show', $municipality->id) }}"
                    class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-2 px-4 rounded transition">
                    Ver
                </a>

                <a href="{{ route('municipalities.edit', $municipality->id) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 px-4 rounded transition">
                    Editar
                </a>
            </div>

            <form action="{{ route('municipalities.destroy', $municipality->id) }}" 
                  method="POST"
                  onsubmit="return confirm('¿Eliminar municipio? Esto puede fallar si tiene excursiones asociadas.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold py-2 px-4 rounded transition">
                    Borrar
                </button>
            </form>
        </div>

    </div>
</div>