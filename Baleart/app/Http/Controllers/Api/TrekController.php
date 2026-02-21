<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trek;
use Illuminate\Http\Request;
use App\Http\Resources\TrekResource;
use App\Http\Requests\TrekRequest;

class TrekController extends Controller
{
   
public function index()
{
    // Añadimos 'meetings.comments' a la carga anidada
    $treks = Trek::with(['municipality.island', 'meetings.comments'])->get();
    return response()->json($treks);
}

public function show(Trek $trek) // Laravel ya buscó el trek por ti gracias al binding
{
    // Cargamos las relaciones necesarias para la ficha de React
    $trek->load(['municipality.island', 'interestingPlaces']);

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
