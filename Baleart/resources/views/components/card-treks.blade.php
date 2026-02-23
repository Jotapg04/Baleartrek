<div class="trek-card pb-6 mb-6 last:border-b-0 last:mb-0">
    <div class="flex justify-between items-start">
        <div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $trek->name }}</h3>
            
            <p class="text-sm text-black-700 mb-1">
                <span class="font-bold">Municipio:</span> {{ $trek->municipality->name }}
            </p>
            
            <p class="text-sm text-black-700 mb-1">
                <span class="font-bold">Lugares remarcables:</span> 
                <span class=" px-2 py-0.5 rounded">
                    {{ $trek->interestingPlaces->pluck('name')->implode(', ') }}
                </span>
            </p>
            
            <p class="mb-2 text-sm">
            <b>Estado:</b>
            @if($trek->status)
            <span class="text-green-600 font-semibold">Activo</span>
            @else
            <span class="text-red-600 font-semibold">No disponible</span>
            @endif
        </p>

            <p class="mb-2 text-sm">
                created at: {{ $trek->created_at }}
            </p>

            <p class="mb-4 text-sm">
                updated at: {{ $trek->updated_at }}
            </p>
        </div>
    </div>

    <div class="flex justify-between items-center mt-4">
        <div class="flex gap-2">
            <a href="{{ route('treks.show', $trek->id) }}" 
               class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Ver
            </a>
            <a href="{{ route('treks.edit', $trek->id) }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Editar
            </a>
        </div>

        <form action="{{ route('treks.destroy', $trek->id) }}" method="POST" onsubmit="return confirm('¿Dar de baja esta excursión?')">
            @csrf
            @method('DELETE')
            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Borrar
            </button>
        </form>
    </div>
</div>