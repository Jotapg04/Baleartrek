<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Trek;
use App\Models\User;
use Illuminate\Http\Request;

class MeetingControllerCRUD extends Controller
{
    /**
     * Muestra el listado de meetings con buscador.
     */
    public function index()
    {
        $meetings = Meeting::with(['trek', 'guideResponsible'])
            ->orderBy('id', 'desc') 
            ->paginate(10);

        return view('admin.meetings.index', compact('meetings'));
    }

    /**
     * Muestra el detalle de un meeting específico.
     */
    public function show($id)
    {
        $meeting = Meeting::with(['trek', 'guideResponsible', 'users', 'comments.user'])->findOrFail($id);
        return view('admin.meetings.show', compact('meeting'));
    }

    public function create()
{
    // Cambia esto para traer TODOS y descartar que sea un problema de 'status'
    $treks = \App\Models\Trek::orderBy('name')->get(); 
    $guides = User::where('role_id', '2')
                      ->orderBy('name')
                      ->get(); 

    return view('admin.meetings.create', compact('treks', 'guides'));
}

public function store(Request $request)
{
    // Validación usando los nombres reales de la BBDD
    $validated = $request->validate([
        'trek_id' => 'required|exists:treks,id',
        'guide_responsible_id' => 'required|exists:users,id',
        'day' => 'required|date|after_or_equal:today',
        'time' => 'required',
        'appDateIni' => 'required|date',
        'appDateEnd' => 'required|date|after:appDateIni|before_or_equal:day',
    ]);

    // Crear el meeting
    Meeting::create($validated);

    return redirect()
        ->route('meetings.index')
        ->with('success', 'Trobada creada correctamente');
}

    /**
     * Muestra el formulario de edición.
     */
    public function edit($id)
    {
        $meeting = Meeting::with('users')->findOrFail($id);
        $guides = User::where('role_id', '2')
                      ->orderBy('name')
                      ->get();
        $treks = Trek::orderBy('name')->get(); 

        return view('admin.meetings.edit', compact('meeting', 'guides', 'treks'));
    }

    /**
     * UPDATE
     */
    public function update(Request $request, $id)
    {
        $meeting = Meeting::findOrFail($id);

        $request->validate([
            'guide_responsible_id' => 'required|exists:users,id',
            'day' => 'required|date',
            'time' => 'required',
            'registration_start' => 'required|date',
            'registration_end' => 'required|date|after_or_equal:registration_start',
            'assistant_guide_id' => 'nullable|exists:users,id',
        ]);

        if ($request->filled('assistant_guide_id') && 
            $request->assistant_guide_id == $request->guide_responsible_id) {
            return back()
                ->withErrors(['assistant_guide_id' => 'El guía acompañante no puede ser la misma persona que el responsable.'])
                ->withInput();
        }

        $meeting->update([
            'guide_responsible_id' => $request->guide_responsible_id,
            'day' => $request->day,
            'time' => $request->time,
            'appDateIni' => $request->registration_start,
            'appDateEnd' => $request->registration_end,
        ]);

        // Para el update, usamos sync para el acompañante
        if ($request->filled('assistant_guide_id')) {
            $meeting->users()->sync([$request->assistant_guide_id]);
        } else {
            $meeting->users()->detach(); // Opcional: quita acompañantes si se deja vacío
        }

        return redirect()->route('meetings.index')->with('success', 'Trobada actualizada correctamente.');
    }

    /**
     * Elimina el meeting y limpia sus relaciones.
     */
    public function destroy($id)
    {
        $meeting = Meeting::findOrFail($id);

        $meeting->users()->detach();

        foreach ($meeting->comments as $comment) {
            $comment->images()->delete(); 
        }

        $meeting->comments()->delete();
        $meeting->delete();

        return redirect()->route('meetings.index')
            ->with('success', 'Meeting eliminado por completo.');
    }
}