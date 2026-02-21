<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trek;
use App\Models\Municipality;
use Illuminate\Http\Request;
use App\Models\InterestingPlace;

class TrekControllerCRUD extends Controller
{
    /**
     * INDEX
     */
    public function index()
    {
        $treks = Trek::with(['municipality', 'interestingPlaces'])
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('admin.treks.index', compact('treks'));
    }

    /**
     * SHOW
     */
    public function show(Trek $trek)
    {
        $trek->load(['municipality', 'interestingPlaces']);

        return view('admin.treks.show', compact('trek'));
    }

    /**
     * EDIT
     */
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

    /**
     * UPDATE
     */
    public function update(Request $request, Trek $trek)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'status' => 'required|in:y,n',
            'municipality_id' => 'required|exists:municipalities,id'
        ]);

        $trek->update($validated);

        $trek->interestingPlaces()->sync(
            $request->interesting_places ?? []
        );

        $trek->touch();

        return redirect()
            ->route('treks.index')
            ->with('success', 'Excursión actualizada');
    }

    /**
     * DELETE (igual filosofía que municipio)
     */
    public function destroy(Trek $trek)
    {
        // quitar lugares remarcables
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
    /**
     * FORM CREATE
     */
    public function create()
    {
        $municipalities = Municipality::all();
        $places = InterestingPlace::orderBy('name')->get();

        return view('admin.treks.create', compact(
            'municipalities',
            'interestingPlaces'
        ));
    }

    /**
     * STORE
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'status' => 'required|in:y,n',
            'municipality_id' => 'required|exists:municipalities,id'
        ]);

        $trek = Trek::create($validated);

        $trek->interestingPlaces()->sync(
            $request->interesting_places ?? []
        );

        return redirect()
            ->route('treks.index')
            ->with('success', 'Excursión creada correctamente');
    }
}