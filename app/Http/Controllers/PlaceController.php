<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;

class PlaceController extends Controller
{
    public function index()
    {
        $places = Place::with(['parent', 'children.children'])
            ->orderBy('label_en')
            ->get();

        $topLevelPlaces = $places->whereNull('parent_id');

        return view('places.index', compact('places', 'topLevelPlaces'));
    }

    public function create()
    {
        $parentOptions = Place::with('parent')
            ->orderBy('label_en')
            ->get();

        return view('places.create', compact('parentOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'identifier' => 'required|unique:2_places,identifier',
            'label_en' => 'required',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        Place::create([
            'identifier' => $request->input('identifier'),
            'label_en' => $request->input('label_en'),
            'description_en' => $request->input('description_en'),
            'parent_id' => $request->input('parent_id'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'tgn_id' => $request->input('tgn_id'),
        ]);

        return redirect()->route('places.index')->with('success', 'Place created!');
    }

    public function show(Place $place)
    {
        $place->load(['parent', 'children', 'games.igdb', 'mappings']);

        return view('places.show', compact('place'));
    }

    public function edit(Place $place)
    {
        // Alle Nachfahren des aktuellen Places sammeln (um Zirkelbezüge zu vermeiden)
        $excludeIds = collect([$place->id]);
        $childIds = Place::where('parent_id', $place->id)->pluck('id');
        $excludeIds = $excludeIds->merge($childIds);
        // Auch Enkel ausschließen
        $grandchildIds = Place::whereIn('parent_id', $childIds)->pluck('id');
        $excludeIds = $excludeIds->merge($grandchildIds);

        $parentOptions = Place::with('parent')
            ->whereNotIn('id', $excludeIds)
            ->orderBy('label_en')
            ->get();

        return view('places.edit', compact('place', 'parentOptions'));
    }

    public function update(Request $request, Place $place)
    {
        $request->validate([
            'identifier' => 'required|unique:2_places,identifier,' . $place->id,
            'label_en' => 'required',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $place->update([
            'identifier' => $request->input('identifier'),
            'label_en' => $request->input('label_en'),
            'description_en' => $request->input('description_en'),
            'parent_id' => $request->input('parent_id'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'tgn_id' => $request->input('tgn_id'),
        ]);

        return redirect()->route('places.index')->with('success', 'Place updated!');
    }

    public function destroy(Place $place)
    {
        $place->games()->detach();
        $place->mappings()->delete();
        $place->delete();

        return response()->json(['success' => true]);
    }
}
