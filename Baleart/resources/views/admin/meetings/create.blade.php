<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Trobada') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <form action="{{ route('meetings.store') }}" method="POST">
                        @csrf

                        {{-- 1. EXCURSIÓN (SELECT) --}}
                        <div class="mb-6">
                            <label class="block mb-2 font-bold ">Seleccionar Excursión</label>
                            <select name="trek_id" class="w-full text-sm @error('trek_id') border-red-500 @enderror">
                                <option value="">-- Seleccionar Trek --</option>
                                @foreach($treks as $trek)
                                    <option value="{{ $trek->id }}" {{ old('trek_id') == $trek->id ? 'selected' : '' }}>
                                        {{ $trek->name }} ({{ $trek->reg_number }})
                                    </option>
                                @endforeach
                            </select>
                            @error('trek_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            {{-- 2. GUÍA RESPONSABLE --}}
                            <div>
                                <label class="block mb-2 font-bold ">Guía Responsable (Principal)</label>
                                <select name="guide_responsible_id" class="w-full text-sm @error('guide_responsible_id') border-red-500 @enderror">
                                    <option value="">-- Seleccionar Guía --</option>
                                    @foreach($guides as $user)
                                        <option value="{{ $user->id }}" {{ old('guide_responsible_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} {{ $user->lastName }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('guide_responsible_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- 3. GUÍA ACOMPAÑANTE --}}
                            <div>
                                <label class="block mb-2 font-bold ">Guía Acompañante (Opcional)</label>
                                <select name="assistant_guide_id" class="w-full  text-sm @error('assistant_guide_id') border-red-500 @enderror">
                                    <option value="">-- Seleccionar --</option>
                                    @foreach($guides as $user)
                                        <option value="{{ $user->id }}" {{ old('assistant_guide_id') == $user->id ? 'selected' : '' }}>
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
                                <label class="block mb-2 font-bold  text-sm">Día del Meeting</label>
                                <input type="date" name="day" value="{{ old('day') }}" class="w-full  text-sm @error('day') border-red-500 @enderror">
                                @error('day')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block mb-2 font-bold  text-sm">Hora del Meeting</label>
                                <input type="time" name="time" value="{{ old('time') }}" class="w-full  text-sm @error('time') border-red-500 @enderror">
                                @error('time')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- 5. FECHAS DE INSCRIPCIÓN (Usando nombres de la BBDD) --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label class="block mb-2 font-bold  text-sm">Inicio de Inscripciones</label>
                                <input type="date" name="appDateIni" value="{{ old('appDateIni') }}" 
                                    class="w-full  text-sm @error('appDateIni') border-red-500 @enderror">
                                @error('appDateIni')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block mb-2 font-bold text-gray-700 text-sm">Cierre de Inscripciones</label>
                                <input type="date" name="appDateEnd" value="{{ old('appDateEnd') }}" 
                                    class="w-full  text-sm @error('appDateEnd') border-red-500 @enderror">
                                @error('appDateEnd')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-100 flex items-center justify-between">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded gap-2 mt-6 transition duration-200">
                                CREAR TROBADA
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>