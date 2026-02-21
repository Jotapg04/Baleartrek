<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle Excursión') }}: {{ $trek->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Reutilizamos la card de treks que definimos anteriormente --}}
                    @include('components.card-treks', ['trek' => $trek])

                </div>
            </div>

            {{-- Botón de retorno al listado --}}
            <div class="mt-4">
                <a href="{{ route('treks.index') }}" class="text-blue-600 hover:text-blue-900 transition font-medium">
                    &larr; Volver al listado de excursiones
                </a>
            </div>

        </div>
    </div>

</x-app-layout>