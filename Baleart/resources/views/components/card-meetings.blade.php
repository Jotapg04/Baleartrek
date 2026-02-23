<div class="place-card pb-4">
    <div class="p-2 text-surface">

        {{-- TÍTULO --}}
        <h5 class="mb-1 text-xl font-bold text-gray-800 leading-tight">
            {{ $meeting->trek->name ?? 'Sin Excursión' }}
        </h5>

        {{-- DATOS TÉCNICOS --}}
        <div class="space-y-3 mb-4">
            <p class="text-sm">
                <b class="text-black-700">Fecha y Hora:</b> 
                <span class="text-black-600">{{ \Carbon\Carbon::parse($meeting->day)->format('d/m/Y') }} a las {{ $meeting->time }}</span>
            </p>

            {{-- CONTADOR DE PERSONAS --}}
            @php
                $totalAsistentes = $meeting->users->count();
            @endphp
            <p class="text-sm">
                <b class="text-black-700">Personas apuntadas:</b> 
                <span class="text-black-600 font-bold">{{ $totalAsistentes }}</span>
            </p>

            <p class="text-sm">
                <b class="text-black-700">Guía Responsable:</b> 
                <span class="text-black-600">{{ $meeting->guideResponsible->name ?? 'N/A' }} {{ $meeting->guideResponsible->lastName ?? '' }}</span>
            </p>

            {{-- GUÍA ACOMPAÑANTE CONDICIONAL --}}
            <p class="text-sm">
                <b class="text-black-700">Guía Acompañante:</b> 
                <span class="text-black-600">
                    @if($totalAsistentes >= 20 && $meeting->users->count() > 0)
                        {{-- Aquí podrías filtrar para mostrar solo al que tenga rol de guía si lo deseas --}}
                        {{ $meeting->users->first()->name }} {{ $meeting->users->first()->lastName }}
                    @else
                        -
                    @endif
                </span>
            </p>

            {{-- Lógica de Inscripción --}}
            @php
                $now = now();
                $isRegistrationOpen = $now->between($meeting->appDateIni, $meeting->appDateEnd);
            @endphp

            <p class="text-sm">
                <b class="text-gray-700">Periodo Inscripción:</b> 
                <span class="text-black-600">del {{ \Carbon\Carbon::parse($meeting->appDateIni)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($meeting->appDateEnd)->format('d/m/Y') }}</span>
            </p>

            <p class="text-sm">
                <b class="text-gray-700">Estado:</b> 
                 @if($now->between($meeting->appDateIni, $meeting->appDateEnd))
                    <span class="text-green-600 font-bold">● Abierta</span>
                @elseif($now->lt($meeting->appDateIni))
                    <span style="color: #f97316;" class="font-bold">● Próximamente</span> 
                @else
                    <span class="text-red-600 font-bold">● Cerrada</span>
                @endif
            </p>
        </div>

        {{-- FECHAS DE SISTEMA --}}
        <p class="mb-2 text-sm ">created at: {{ $meeting->created_at }}</p>
        <p class="mb-4 text-sm ">updated at: {{ $meeting->updated_at }}</p>

        {{-- BOTONES DE ACCIÓN --}}
        <div class="flex justify-between items-center mt-4">
            <div class="flex gap-2">
                <a href="{{ route('meetings.show', $meeting->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition text-sm">Ver</a>
                <a href="{{ route('meetings.edit', $meeting->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition text-sm">Editar</a>
            </div>

            <form action="{{ route('meetings.destroy', $meeting->id) }}" method="POST" onsubmit="return confirm('¿Borrar esta trobada?')">
                @csrf @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition text-sm">Borrar</button>
            </form>
        </div>
    </div>
</div>