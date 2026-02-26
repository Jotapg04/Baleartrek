<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
    public function join($id)
    {
        $user = Auth::user();
        $meeting = Meeting::findOrFail($id);

        // Comprobar si ya está apuntado para no duplicar
        if ($meeting->users()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'Ya estás apuntado a esta excursión'], 400);
        }

        // Comprobar si hay plazas (límite 40)
        if ($meeting->users()->count() >= 40) {
            return response()->json(['message' => 'Lo sentimos, esta reunión está llena'], 400);
        }

        // Adjuntar el usuario a la reunión (tabla pivote)
        $meeting->users()->attach($user->id);

        return response()->json(['message' => 'Te has apuntado correctamente']);
    }
}