<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle de la Trobada') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- DEFINICIÓN DE VARIABLES PARA EVITAR ERRORES --}}
                    @php
                        $totalAsistentes = $meeting->users->count();
                        $now = now();
                        $isRegistrationOpen = $now->between($meeting->appDateIni, $meeting->appDateEnd);
                    @endphp

                    <div class="place-card pb-6 mb-6 last:border-b-0 last:mb-0">
                        <div class="flex justify-between items-start">
                            <div>
                                {{-- NOMBRE DE LA EXCURSIÓN --}}
                                <h3 class="text-xl font-bold text-gray-800 mb-2">
                                    {{ $meeting->trek->name ?? 'Sin Excursión' }}
                                </h3>
                                
                                {{-- ID Y GUÍA --}}
                                <p class="text-sm  mb-1">
                                    <span class="font-bold">ID Trobada:</span> 
                                    <span class="text-blue-600 font-semibold text-xs tracking-wide">
                                        #{{ $meeting->id }}
                                    </span>
                                </p>

                                <p class="text-sm mb-1">
                                    <span class="font-bold">Guía Responsable:</span> 
                                    <span >
                                        {{ $meeting->guideResponsible->name ?? 'N/A' }} {{ $meeting->guideResponsible->lastName ?? '' }}
                                    </span>
                                </p>
                                <p class="text-sm mb-1">
                                    <b class="text-black-700">Guía Acompañante:</b> 
                                        <span class="text-black-600">
                                            @if($totalAsistentes >= 20 && $meeting->users->count() > 0)
                                                {{ $meeting->users->first()->name }} {{ $meeting->users->first()->lastName }}
                                            @else
                                                -
                                             @endif
                                        </span>
                                </p>

                                {{-- NÚMERO DE ASISTENTES (Como en el index) --}}
                                <p class="text-sm mb-1">
                                    <span class="font-bold ">Asistentes:</span>
                                    <span class="text-black-600">{{ $totalAsistentes }}</span>
                                </p>
                                
                                {{-- FECHA Y HORA --}}
                                <p class="text-sm mb-1">
                                    <span class="font-bold">Fecha y Hora:</span> 
                                    <code class="px-2 py-0.5 rounded text-xs">
                                        {{ \Carbon\Carbon::parse($meeting->day)->format('d/m/Y') }} a las {{ $meeting->time }}
                                    </code>
                                </p>

                                {{-- ESTADO INSCRIPCIÓN --}}
                                <p class="text-sm mb-1">
                                    <span class="font-bold">Estado Inscripción:</span> 
                                    @if($isRegistrationOpen)
                                        <span class="text-green-600 font-bold">● Abierta</span>
                                        <span class="text-[10px] font-normal">(Cierra el {{ \Carbon\Carbon::parse($meeting->appDateEnd)->format('d/m/Y') }})</span>
                                    @elseif($now->lt($meeting->appDateIni))
                                        <span style="color: #f97316;" class="font-bold">● Próximamente</span>
                                        <span class="text-[10px]  font-normal">(Abre el {{ \Carbon\Carbon::parse($meeting->appDateIni)->format('d/m/Y') }})</span>
                                    @else
                                        <span class="text-red-600 font-bold">● Cerrada</span>
                                    @endif
                                </p>

                                {{-- TIMESTAMPS --}}
                                <p class="mt-4 mb-1 text-sm">
                                    created at: {{ $meeting->created_at }}
                                </p>

                                <p class="mb-4 text-sm">
                                    updated at: {{ $meeting->updated_at }}
                                </p>
                            </div>
                        </div>

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
            </div>
        </div>
    </div>
</x-app-layout>