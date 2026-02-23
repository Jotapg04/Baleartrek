<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InterestingPlace; 
use Illuminate\Http\Request;

class InterestingPlaceControllerCRUD extends Controller
{

    public function index()
    {
       
        $interestingPlaces = InterestingPlace::with(['type', 'treks'])->paginate(10);

        return view('admin.interesting_places.index', compact('interestingPlaces'));
    }

    public function show($id)
    {
        $place = InterestingPlace::with(['type', 'treks'])->findOrFail($id);
        return view('admin.interesting_places.show', compact('place'));
    }

    public function destroy($id)
    {
        $place = InterestingPlace::findOrFail($id);
        $place->treks()->detach();

        $place->delete();

        return redirect()->route('interesting-places.index')
            ->with('success', 'Lugar eliminado correctamente y desvinculado de sus excursiones.');
    }

    public function edit($id)
    {
        $place = InterestingPlace::findOrFail($id);
        $types = \App\Models\PlaceType::all(); 
        
        return view('admin.interesting_places.edit', compact('place', 'types'));
    }

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name'          => 'required|string|max:255',
        'place_type_id' => 'required|exists:place_types,id', 
        'gps'           => 'required|string', 
    ]);

    $place = InterestingPlace::findOrFail($id);
    $place->update($validated);

    return redirect()->route('interesting-places.index')
        ->with('success', 'Lugar actualizado correctamente.');
}
}