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

                    <div class="place-card pb-6 mb-6 last:border-b-0 last:mb-0">
                        <div class="flex justify-between items-start">
                            <div>
                                {{-- NOMBRE DE LA EXCURSIÓN --}}
                                <h3 class="text-xl font-bold text-gray-800 mb-2">
                                    {{ $meeting->trek->name ?? 'Sin Excursión' }}
                                </h3>
                                
                                {{-- ID Y GUÍA --}}
                                <p class="text-sm text-gray-700 mb-1">
                                    <span class="font-bold">ID Trobada:</span> 
                                    <span class="text-blue-600 font-semibold text-xs tracking-wide">
                                        #{{ $meeting->id }}
                                    </span>
                                </p>

                                <p class="text-sm text-gray-700 mb-1">
                                    <span class="font-bold">Guía Responsable:</span> 
                                    <span >
                                        {{ $meeting->guideResponsible->name ?? 'N/A' }} {{ $meeting->guideResponsible->lastName ?? '' }}
                                    </span>
                                </p>
                                
                                {{-- FECHA Y HORA --}}
                                <p class="text-sm mb-1">
                                    <span class="font-bold">Fecha y Hora:</span> 
                                    <code class="px-2 py-0.5 rounded text-xs">
                                        {{ \Carbon\Carbon::parse($meeting->day)->format('d/m/Y') }} a las {{ $meeting->time }}
                                    </code>
                                </p>

                                {{-- ESTADO INSCRIPCIÓN (Lógica de negocio) --}}
                                @php
                                    $eventDate = \Carbon\Carbon::parse($meeting->day);
                                    $openingDate = $eventDate->copy()->subMonth();
                                    $closingDate = $eventDate->copy()->subWeek();
                                    $now = now();
                                    $isRegistrationOpen = $now->between($openingDate, $closingDate);
                                @endphp

                                <p class="text-sm text-gray-700 mb-1">
                                    <span class="font-bold">Estado Inscripción:</span> 
                                    @if($isRegistrationOpen)
                                        <span class="text-green-600 font-bold">● Abierta</span>
                                        <span class="text-[10px] text-gray-400 font-normal italic">(Cierra el {{ $closingDate->format('d/m/Y') }})</span>
                                    @else
                                        <span class="text-red-600 font-bold">● Cerrada</span>
                                    @endif
                                </p>

                                {{-- TIMESTAMPS (Igual que en Interesting Places) --}}
                                <p class="mt-4 mb-1 text-sm">
                                    created at: {{ $meeting->created_at }}
                                </p>

                                <p class="mb-4 text-sm">
                                    updated at: {{ $meeting->updated_at }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

            {{-- ENLACE DE RETORNO --}}
            <div class="mt-4">
                <a href="{{ route('meetings.index') }}" class="text-blue-600 hover:text-blue-900 transition font-medium">
                    &larr; Volver al listado de trobadas
                </a>
            </div>
        </div>
    </div>
</x-app-layout>