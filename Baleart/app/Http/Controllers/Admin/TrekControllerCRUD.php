<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trek;
use App\Models\Municipality;
use Illuminate\Http\Request;
use App\Models\InterestingPlace;

class TrekControllerCRUD extends Controller
{
   
    public function index()
    {
        $treks = Trek::with(['municipality', 'interestingPlaces'])
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('admin.treks.index', compact('treks'));
    }


    public function show(Trek $trek)
    {
        $trek->load(['municipality', 'interestingPlaces']);

        return view('admin.treks.show', compact('trek'));
    }


    public function create()
    {
        $municipalities = Municipality::all();
        $interestingPlaces = InterestingPlace::orderBy('name')->get();

        return view('admin.treks.create', compact(
            'municipalities',
            'interestingPlaces'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'status' => 'required|in:y,n',
            'municipality_id' => 'required|exists:municipalities,id',
            'interesting_places' => 'nullable|array',
            'interesting_places.*' => 'exists:interesting_places,id',
        ]);

        $lastTrek = Trek::orderBy('id', 'desc')->first();
        $nextNumber = $lastTrek ? ($lastTrek->id + 1) : 1;
        
       
        $validated['reg_number'] = 'T' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
        $validated['user_id'] = 1; //es 1 porque es el admin 

        $trek = Trek::create($validated);

        if ($request->has('interesting_places')) {
            $trek->interestingPlaces()->sync($request->interesting_places);
        }

        return redirect()
            ->route('treks.index')
            ->with('success', 'Excursión creada correctamente con registro ' . $validated['reg_number']);
    }

    public function edit(Trek $trek)
    {
        $municipalities = Municipality::all();
        $interestingPlaces = InterestingPlace::orderBy('name')->get();

        return view('admin.treks.edit', compact(
            'trek',
            'municipalities',
            'interestingPlaces'
        ));
    }

    public function update(Request $request, Trek $trek)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'status' => 'required|in:y,n',
            'municipality_id' => 'required|exists:municipalities,id'
        ]);

        $trek->update($validated);


        $trek->interestingPlaces()->sync($request->interesting_places ?? []);

        $trek->touch(); // Actualiza el campo updated_at

        return redirect()
            ->route('treks.index')
            ->with('success', 'Excursión actualizada correctamente');
    }


    public function destroy(Trek $trek)
    {
        
        $trek->interestingPlaces()->detach();

        foreach ($trek->meetings as $meeting) {
            foreach ($meeting->comments as $comment) {
                $comment->images()->delete();
                $comment->delete();
            }
            $meeting->users()->detach();
            $meeting->delete();
        }

        $trek->delete();

        return redirect()
            ->route('treks.index')
            ->with('success', 'Excursión eliminada');
    }
}