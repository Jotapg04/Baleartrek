<div class="user-card">
    <div class="p-6 text-surface">

        {{-- NOMBRE --}}
        <h5 class="mb-2 text-xl font-medium leading-tight">
            {{ $user->name }} {{ $user->lastname }}
        </h5>

        {{-- DATOS --}}
        <p class="mb-2 text-sm">
            <b>Email:</b> {{ $user->email }}
        </p>

        <p class="mb-2 text-sm">
            <b>DNI:</b> {{ $user->dni }}
        </p>

        <p class="mb-2 text-sm">
            <b>Teléfono:</b> {{ $user->phone }}
        </p>

        <p class="mb-2 text-sm">
            <b>Rol:</b> {{ $user->role->name }}
        </p>

        {{-- ESTADO --}}
        <p class="mb-2 text-sm">
            <b>Estado:</b>
            @if($user->active)
            <span class="text-green-600 font-semibold">Activo</span>
            @else
            <span class="text-red-600 font-semibold">Dado de baja</span>
            @endif
        </p>

        {{-- FECHAS --}}
        <p class="mb-2 text-sm">
            created at: {{ $user->created_at }}
        </p>

        <p class="mb-4 text-sm">
            updated at: {{ $user->updated_at }}
        </p>

        {{-- BOTONES --}}
        <div class="flex items-center justify-between">

            <div class="flex gap-x-4">
                <a href="{{ route('users.show', $user->id) }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Ver
                </a>

                <a href="{{ route('users.edit', $user->id) }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Editar
                </a>
            </div>

            <form action="{{ route('users.destroy', $user->id) }}"
                method="POST">
                @csrf
                @method('DELETE')

                <button type="submit"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Borrar
                </button>
            </form>

        </div>

    </div>
</div>