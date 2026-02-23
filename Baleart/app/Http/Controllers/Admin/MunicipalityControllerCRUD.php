<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Municipality;
use App\Models\Island;
use App\Models\Zone;
use Illuminate\Http\Request;

class MunicipalityControllerCRUD extends Controller
{
    public function index()
    {
        $municipalities = Municipality::with(['island', 'zone', 'treks'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.municipalities.index', compact('municipalities'));
    }

    public function show($id)
    {
        $municipality = Municipality::with(['island', 'zone', 'treks'])->findOrFail($id);
        return view('admin.municipalities.show', compact('municipality'));
    }

    public function edit($id)
    {
        $municipality = Municipality::findOrFail($id);
        $islands = Island::all();
        $zones = Zone::all();

        return view('admin.municipalities.edit', compact('municipality', 'islands', 'zones'));
    }

    public function update(Request $request, $id)
    {
        $municipality = Municipality::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'island_id' => 'required|exists:islands,id',
            'zone_id' => 'required|exists:zones,id',
        ]);

        $municipality->update($request->all());

        return redirect()->route('municipalities.index')->with('success', 'Municipio actualizado correctamente.');
    }

    public function create()
    {
        // Necesitamos las islas y zonas para los desplegables del formulario
        $islands = Island::all();
        $zones = Zone::all();

        return view('admin.municipalities.create', compact('islands', 'zones'));
    }

    /**
     * STORE
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:municipalities,name',
            'island_id' => 'required|exists:islands,id',
            'zone_id' => 'required|exists:zones,id',
        ]);

        Municipality::create($validated);

        return redirect()
            ->route('municipalities.index')
            ->with('success', 'Municipio creado correctamente.');
    }

    public function destroy($id)
    {
        $municipality = Municipality::findOrFail($id);

        if ($municipality->treks()->count() > 0) {
            return redirect()->route('municipalities.index')
                ->with('error', 'No se puede borrar: tiene rutas asociadas.');
        }

        $municipality->delete();

        return redirect()->route('municipalities.index')->with('success', 'Municipio eliminado.');
    }
}