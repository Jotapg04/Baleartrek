<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InterestingPlace; 
use App\Models\PlaceType; // Asegúrate de tener este modelo
use Illuminate\Http\Request;

class InterestingPlaceControllerCRUD extends Controller
{
    public function index()
    {
        $interestingPlaces = InterestingPlace::with(['type', 'treks'])
            ->orderBy('id', 'desc') // Añadido para ver los nuevos primero
            ->paginate(10);

        return view('admin.interesting_places.index', compact('interestingPlaces'));
    }

    /**
     * FORM CREATE - Añadido
     */
    public function create()
    {
        $types = PlaceType::all(); 
        return view('admin.interesting_places.create', compact('types'));
    }

    /**
     * STORE - Añadido
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name'          => 'required|string|max:255|unique:interesting_places,name',
        'place_type_id' => 'required|exists:place_types,id', 
        // Añadimos unique:tabla,columna
        'gps'           => 'required|string|unique:interesting_places,gps', 
    ], [
        // Opcional: Personaliza el mensaje de error
        'gps.unique' => 'Ya existe un lugar registrado con estas coordenadas GPS.',
    ]);

    InterestingPlace::create($validated);

    return redirect()->route('interesting-places.index')
        ->with('success', 'Lugar de interés creado correctamente.');
}

    public function show($id)
    {
        $place = InterestingPlace::with(['type', 'treks'])->findOrFail($id);
        return view('admin.interesting_places.show', compact('place'));
    }

    public function edit($id)
    {
        $place = InterestingPlace::findOrFail($id);
        $types = PlaceType::all(); 
        
        return view('admin.interesting_places.edit', compact('place', 'types'));
    }

    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name'          => 'required|string|max:255|unique:interesting_places,name,'.$id,
        'place_type_id' => 'required|exists:place_types,id', 
        'gps'           => 'required|string|unique:interesting_places,gps,'.$id,
    ]);

    $place = InterestingPlace::findOrFail($id);
    $place->update($validated);

    return redirect()->route('interesting-places.index')
        ->with('success', 'Lugar actualizado correctamente.');
}

    public function destroy($id)
    {
        $place = InterestingPlace::findOrFail($id);
        $place->treks()->detach();
        $place->delete();

        return redirect()->route('interesting-places.index')
            ->with('success', 'Lugar eliminado correctamente y desvinculado de sus excursiones.');
    }
}