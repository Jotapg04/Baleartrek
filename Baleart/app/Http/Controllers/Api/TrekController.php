<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trek;
use Illuminate\Http\Request;
use App\Http\Resources\TrekResource;
use App\Http\Requests\TrekRequest;

class TrekController extends Controller
{
    public function index(Request $request)
    {
        $treks = Trek::all();
        return TrekResource::collection($treks);

    }

    public function show(Trek $trek)
    {
        return new TrekResource($trek);
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
