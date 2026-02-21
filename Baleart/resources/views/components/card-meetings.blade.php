<div class="meeting-card bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
    <div class="p-6 text-surface">

        {{-- TÍTULO Y EXCURSIÓN --}}
        <h5 class="mb-1 text-xl font-medium leading-tight">
            {{ $meeting->trek->name }}
        </h5>
        <p class="mb-4 text-xs text-gray-500 uppercase font-bold">
            ID Trobada: #{{ $meeting->id }}
        </p>

        {{-- DATOS DE FECHA Y GUÍA --}}
        <div class="space-y-2 mb-4">
            <p class="text-sm">
                <b class="text-gray-700">Fecha y Hora:</b> 
                {{ \Carbon\Carbon::parse($meeting->day)->format('d/m/Y') }} a las {{ $meeting->time }}
            </p>

            <p class="text-sm">
                <b class="text-gray-700">Guía Responsable:</b> 
                {{ $meeting->guideResponsible->name }} {{ $meeting->guideResponsible->lastname }}
            </p>
        </div>

        {{-- LÓGICA DE INSCRIPCIÓN (Basada en rúbrica: 1 mes antes / 1 semana antes) --}}
        @php
            $eventDate = \Carbon\Carbon::parse($meeting->day);
            $openingDate = $eventDate->copy()->subMonth();
            $closingDate = $eventDate->copy()->subWeek();
            $now = now();
            
            $isRegistrationOpen = $now->between($openingDate, $closingDate);
        @endphp

        <div class="mb-4 p-3 rounded bg-gray-50 border border-gray-100">
            <p class="text-xs font-semibold mb-1 uppercase text-gray-500">Estado Inscripción:</p>
            @if($isRegistrationOpen)
                <span class="text-green-600 font-bold text-sm">● Abierta</span>
                <p class="text-[10px] text-gray-500">Cierra el: {{ $closingDate->format('d/m/Y') }}</p>
            @else
                <span class="text-red-600 font-bold text-sm">● Cerrada</span>
                <p class="text-[10px] text-gray-500">Fuera del rango ({{ $openingDate->format('d/m/Y') }} - {{ $closingDate->format('d/m/Y') }})</p>
            @endif
        </div>

        {{-- PUNTUACIÓN MEDIA --}}
        <p class="mb-4 text-sm">
            <b class="text-gray-700">Puntuación Media:</b>
            @if($meeting->average_score)
                <span class="bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded font-bold">
                    {{ $meeting->average_score }} / 5
                </span>
            @else
                <span class="text-gray-400 italic">Sin valoraciones</span>
            @endif
        </p>

        {{-- BOTONES DE ACCIÓN (BACK OFFICE) --}}
        <div class="flex flex-col gap-y-2 mt-6">
            <div class="flex gap-x-2">
                <a href="{{ route('meetings.show', $meeting->id) }}"
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center text-xs font-bold py-2 rounded transition">
                    Ver Inscritos
                </a>

                <a href="{{ route('meetings.edit', $meeting->id) }}"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center text-xs font-bold py-2 rounded transition">
                    Editar / Guías
                </a>
            </div>

            <form action="{{ route('meetings.destroy', $meeting->id) }}" method="POST" 
                  onsubmit="return confirm('¿Eliminar esta trobada? Se borrarán las inscripciones.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full bg-red-500 hover:bg-red-600 text-white text-xs font-bold py-2 rounded transition">
                    Eliminar Trobada
                </a>
            </form>
        </div>

    </div>
</div>