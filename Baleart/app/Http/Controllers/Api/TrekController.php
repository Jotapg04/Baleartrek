<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrekRequest;
use App\Http\Resources\TrekResource;
use App\Models\Trek;
use Illuminate\Http\Request;

class TrekController extends Controller
{

public function index(Request $request)
{
    // Empezamos la consulta con las relaciones necesarias
    $query = Trek::with(['municipality.island', 'meetings.comments']);

    // --- PUNTO 3: FILTRADO ---
    if ($request->filled('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    if ($request->filled('island')) {
        $query->whereHas('municipality.island', function($q) use ($request) {
            $q->where('name', 'like', '%' . $request->island . '%');
        });
    }

    // --- PUNTO 3: PAGINACIÓN ---
    // Cambiamos .get() por .paginate() para cumplir la rúbrica
    return response()->json($query->paginate(9));
}

// --- PUNTO 2: EXCURSIONES DESTACADAS ---
public function featured()
{
    try {
        // Traemos todos los treks con sus notas para poder comparar
        $treks = Trek::with(['municipality.island', 'meetings.comments'])->get();

        // Calculamos la nota media de cada uno antes de ordenar
        $treks->each(function ($trek) {
            $allScores = $trek->meetings->flatMap(function ($meeting) {
                return $meeting->comments->pluck('score');
            });
            // Guardamos la media en un atributo temporal
            $trek->final_score = $allScores->count() > 0 ? $allScores->avg() : 0;
        });

        // Ordenamos la colección de mayor a menor nota y pillamos las 3 mejores
        $featured = $treks->sortByDesc('final_score')->take(3)->values();

        return response()->json($featured);

    } catch (\Exception $e) {
        return response()->json(Trek::with(['municipality.island', 'meetings.comments'])->take(3)->get());
    }
}

public function show(Trek $trek) 
{
    $trek->load([
        'municipality.island', 
        'interestingPlaces.type',
        'meetings' => function($query) {
            $query->withCount('users')
                  ->with('guideResponsible');
        }
    ]);

    return response()->json($trek);
}


    public function store(TrekRequest $request)
    {
        $trek = Trek::create($request->validated());
        return new TrekResource($trek);
    }

    public function update(TrekRequest $request, Trek $trek)
    {
        $trek->update($request->validated());
        return new TrekResource($trek);
    }

    public function byIsland($isla)
{
    $treks = Trek::with(['municipality', 'municipality.island'])
        ->whereHas('municipality.island', function($query) use ($isla) {
            $query->where('name', 'like', "%$isla%"); 
        })
        ->get();

    return response()->json($treks);
}


}
