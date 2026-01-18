<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trope;
use App\Models\AlternativeName;

class TropeController extends Controller
{
    public function index()
    {
        $tropes = Trope::orderBy('label_en')->get();

        return view('tropes.index', compact('tropes'));
    }

    public function create()
    {
        $mappingTypes = ['exactMatch', 'closeMatch', 'broadMatch', 'narrowMatch', 'relatedMatch'];

        return view('tropes.create', compact('mappingTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'identifier' => 'required|unique:2_tropes,identifier',
            'label_en' => 'required',
            'tvtropes_url' => 'nullable|url',
        ]);

        $trope = Trope::create([
            'identifier' => $request->input('identifier'),
            'label_en' => $request->input('label_en'),
            'description_en' => $request->input('description_en'),
            'tvtropes_url' => $request->input('tvtropes_url'),
            'tvtropes_mapping' => $request->input('tvtropes_mapping'),
            'wikidata_id' => $request->input('wikidata_id'),
            'wikidata_mapping' => $request->input('wikidata_mapping'),
        ]);

        // Alternative Names speichern
        if ($request->has('alternative_names')) {
            foreach ($request->input('alternative_names') as $altName) {
                if (!empty($altName['name'])) {
                    AlternativeName::create([
                        'vocabulary_type' => 'trope',
                        'vocabulary_id' => $trope->id,
                        'name' => $altName['name'],
                        'language' => $altName['language'] ?? 'en',
                    ]);
                }
            }
        }

        return redirect()->route('tropes.index')->with('success', 'Trope created!');
    }

    public function show(Trope $trope)
    {
        $trope->load(['games.igdb', 'alternativeNames']);

        return view('tropes.show', compact('trope'));
    }

    public function edit(Trope $trope)
    {
        $trope->load('alternativeNames');
        $mappingTypes = ['exactMatch', 'closeMatch', 'broadMatch', 'narrowMatch', 'relatedMatch'];

        return view('tropes.edit', compact('trope', 'mappingTypes'));
    }

    public function update(Request $request, Trope $trope)
    {
        $request->validate([
            'identifier' => 'required|unique:2_tropes,identifier,' . $trope->id,
            'label_en' => 'required',
            'tvtropes_url' => 'nullable|url',
        ]);

        $trope->update([
            'identifier' => $request->input('identifier'),
            'label_en' => $request->input('label_en'),
            'description_en' => $request->input('description_en'),
            'tvtropes_url' => $request->input('tvtropes_url'),
            'tvtropes_mapping' => $request->input('tvtropes_mapping'),
            'wikidata_id' => $request->input('wikidata_id'),
            'wikidata_mapping' => $request->input('wikidata_mapping'),
        ]);

        // Alternative Names aktualisieren
        $trope->alternativeNames()->delete();
        if ($request->has('alternative_names')) {
            foreach ($request->input('alternative_names') as $altName) {
                if (!empty($altName['name'])) {
                    AlternativeName::create([
                        'vocabulary_type' => 'trope',
                        'vocabulary_id' => $trope->id,
                        'name' => $altName['name'],
                        'language' => $altName['language'] ?? 'en',
                    ]);
                }
            }
        }

        return redirect()->route('tropes.index')->with('success', 'Trope updated!');
    }

    public function destroy(Trope $trope)
    {
        $trope->alternativeNames()->delete();
        $trope->games()->detach();
        $trope->delete();

        return response()->json(['success' => true]);
    }
}
