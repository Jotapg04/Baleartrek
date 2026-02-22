<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InterestingPlace; // Asegúrate de que tu modelo se llame así
use Illuminate\Http\Request;

class InterestingPlaceControllerCRUD extends Controller
{
    /**
     * Muestra el listado de lugares remarcables.
     */
    public function index()
    {
        // Traemos los lugares con sus relaciones para evitar errores en la card
        // 'type' es la relación con el modelo de tipos y 'treks' para el contador
        $interestingPlaces = InterestingPlace::with(['type', 'treks'])->paginate(10);

        return view('admin.interesting_places.index', compact('interestingPlaces'));
    }

    /**
     * Muestra el detalle de un lugar.
     */
    public function show($id)
    {
        $place = InterestingPlace::with(['type', 'treks'])->findOrFail($id);
        return view('admin.interesting_places.show', compact('place'));
    }

    /**
     * Elimina el lugar de la base de datos.
     */
    /**
 * Elimina el lugar de la base de datos.
 */
    public function destroy($id)
    {
        $place = InterestingPlace::findOrFail($id);

        // 1. Rompemos la relación con las excursiones en la tabla intermedia
        // Esto borra las entradas en 'interesting_place_trek' relacionadas con este ID
        $place->treks()->detach();

        // 2. Ahora que el lugar está libre de vínculos, lo podemos borrar
        $place->delete();

        return redirect()->route('interesting-places.index')
            ->with('success', 'Lugar eliminado correctamente y desvinculado de sus excursiones.');
    }

    public function edit($id)
    {
        $place = InterestingPlace::findOrFail($id);
        // Cargamos todos los tipos para el desplegable
        $types = \App\Models\PlaceType::all(); 
        
        return view('admin.interesting_places.edit', compact('place', 'types'));
    }

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name'          => 'required|string|max:255',
        'place_type_id' => 'required|exists:place_types,id', 
        'gps'           => 'required|string', // Ahora se llama gps
    ]);

    $place = InterestingPlace::findOrFail($id);
    $place->update($validated);

    return redirect()->route('interesting-places.index')
        ->with('success', 'Lugar actualizado correctamente.');
}
}