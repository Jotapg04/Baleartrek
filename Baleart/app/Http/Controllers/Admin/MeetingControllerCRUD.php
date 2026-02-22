<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingControllerCRUD extends Controller
{
    /**
     * Muestra el listado de meetings con buscador.
     */
    public function index()
{
    // Ordenamos por 'id' de forma descendente (desc) para ver las últimas creadas arriba
    // Si las prefieres de la 1 en adelante, usa 'asc'
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

    /**
     * Muestra el formulario de edición con los datos necesarios.
     */
public function edit($id)
{
    $meeting = Meeting::with('users')->findOrFail($id);
    $allUsers = \App\Models\User::all(); 

    // Solo enviamos el meeting y los usuarios
    return view('admin.meetings.edit', compact('meeting', 'allUsers'));
}

public function update(Request $request, $id)
{
    $meeting = Meeting::findOrFail($id);

    // 1. Validación de los campos del formulario
    $request->validate([
        'guide_responsible_id' => 'required|exists:users,id',
        'day' => 'required|date',
        'time' => 'required',
        'registration_start' => 'required|date',
        'registration_end' => 'required|date|after_or_equal:registration_start',
        'assistant_guide_id' => 'nullable|exists:users,id',
    ]);

    // 2. Validación lógica: El acompañante no puede ser el mismo que el responsable
    if ($request->filled('assistant_guide_id') && 
        $request->assistant_guide_id == $request->guide_responsible_id) {
        
        return back()
            ->withErrors(['assistant_guide_id' => 'El guía acompañante no puede ser la misma persona que el responsable.'])
            ->withInput();
    }

    // 3. Actualizamos el meeting mapeando los nombres del formulario a la DB
    $meeting->update([
        'guide_responsible_id' => $request->guide_responsible_id,
        'day' => $request->day,
        'time' => $request->time,
        'appDateIni' => $request->registration_start, // Mapeo manual
        'appDateEnd' => $request->registration_end,   // Mapeo manual
    ]);

    // 4. Gestión del acompañante en la tabla pivote
    if ($request->filled('assistant_guide_id')) {
        // Usamos sync para que solo ese usuario sea el "acompañante" oficial en la pivote
        // (Nota: si ya hay usuarios apuntados, esto podría borrarlos según tu lógica de inscripciones. 
        // Si la tabla pivote es compartida, habría que usar 'syncWithoutDetaching' o lógica específica)
        $meeting->users()->sync([$request->assistant_guide_id]);
    }

    return redirect()->route('meetings.index')->with('success', 'Trobada actualizada correctamente.');
}

    /**
     * Elimina el meeting y limpia sus relaciones.
     */
    public function destroy($id)
{
    $meeting = Meeting::findOrFail($id);

    // 1. Desvincular participantes (tabla pivote meeting_user)
    $meeting->users()->detach();

    // 2. Limpiar Imágenes de los Comentarios
    // Recorremos cada comentario del meeting para borrar sus fotos primero
    foreach ($meeting->comments as $comment) {
        $comment->images()->delete(); 
    }

    // 3. Borrar los Comentarios
    $meeting->comments()->delete();

    // 4. Finalmente, borrar el Meeting
    $meeting->delete();

    return redirect()->route('meetings.index')
        ->with('success', 'Meeting eliminado por completo (incluyendo comentarios e imágenes).');
}
}