<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Trobada') }} #{{ $meeting->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('meetings.update', $meeting->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- 1. EXCURSIÓN (SOLO LECTURA) --}}
                        <div class="mb-6">
                            <label class="block mb-2 font-bold text-gray-700">Excursión Asociada</label>
                            <p class="text-lg font-semibold text-gray-600 bg-gray-50 p-2 rounded">
                                {{ $meeting->trek->name ?? 'Sin excursión' }}
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            {{-- 2. GUÍA RESPONSABLE (ÚNICO) --}}
                            <div>
                                <label class="block mb-2 font-bold text-gray-700">Guía Responsable (Principal)</label>
                                <select name="guide_responsible_id" class="w-full border-gray-300 rounded shadow-sm text-sm">
                                    @foreach($allUsers as $user)
                                        <option value="{{ $user->id }}" {{ $meeting->guide_responsible_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} {{ $user->lastName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Campo Guía Acompañante --}}
                            <div>
                                <label class="block mb-2 font-bold text-gray-700">Guía Acompañante</label>
                                <select name="assistant_guide_id" class="w-full border-gray-300 rounded shadow-sm @error('assistant_guide_id') border-red-500 @enderror">
                                    <option value="">-- Seleccionar --</option>
                                    @foreach($allUsers as $user)
                                        <option value="{{ $user->id }}" {{ $meeting->users->contains($user->id) ? 'selected' : '' }}>
                                            {{ $user->name }} {{ $user->lastName }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('assistant_guide_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- 4. DÍA Y HORA DEL EVENTO --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block mb-2 font-bold text-gray-700 text-sm">Día del Meeting</label>
                                <input type="date" name="day" value="{{ old('day', $meeting->day) }}" class="w-full border-gray-300 rounded shadow-sm text-sm">
                            </div>
                            <div>
                                <label class="block mb-2 font-bold text-gray-700 text-sm">Hora del Meeting</label>
                                <input type="time" name="time" value="{{ old('time', $meeting->time) }}" class="w-full border-gray-300 rounded shadow-sm text-sm">
                            </div>
                        </div>

                        {{-- 5. FECHAS DE INSCRIPCIÓN --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label class="block mb-2 font-bold text-gray-700 text-sm">Inicio de Inscripciones</label>
                                <input type="date" name="registration_start" 
                                    value="{{ old('registration_start', $meeting->registration_start ?? \Carbon\Carbon::parse($meeting->day)->subMonth()->format('Y-m-d')) }}" 
                                    class="w-full border-gray-300 rounded shadow-sm text-sm">
                            </div>
                            <div>
                                <label class="block mb-2 font-bold text-gray-700 text-sm">Cierre de Inscripciones</label>
                                <input type="date" name="registration_end" 
                                    value="{{ old('registration_end', $meeting->registration_end ?? \Carbon\Carbon::parse($meeting->day)->subWeek()->format('Y-m-d')) }}" 
                                    class="w-full border-gray-300 rounded shadow-sm text-sm">
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-100 flex items-center justify-between">
                            <button
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded gap-2 mt-6">
                                ACTUALIZAR
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>