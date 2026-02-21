<x-app-layout>

    <x-slot name="header">
        Editar Usuario : {{ $user->name }} {{ $user->lastname }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form action="{{ route('users.update',$user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- CAMBIAR ROL --}}
                        <label class="block mb-2 font-semibold">Rol</label>
                        <select name="role_id" class="w-full mb-6 border-gray-300 rounded">

                            @foreach($roles as $role)
                            <option value="{{ $role->id }}"
                                {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                            @endforeach

                        </select>

                        {{-- DAR DE BAJA --}}
                        <label class="block mb-2 font-semibold">Estado</label>
                        <select name="active" class="w-full mb-6 border-gray-300 rounded">
                            <option value="1" {{ $user->active ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ !$user->active ? 'selected' : '' }}>Dado de baja</option>
                        </select>

                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                            Actualizar
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>

</x-app-layout>