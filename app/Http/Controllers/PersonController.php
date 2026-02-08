<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Person;
use App\Models\AlternativeName;

class PersonController extends Controller
{
    public function index()
    {
        $persons = Person::orderBy('label_en')->get();

        return view('persons.index', compact('persons'));
    }

    public function create()
    {
        $mappingTypes = ['exactMatch', 'closeMatch', 'broadMatch', 'narrowMatch', 'relatedMatch'];

        return view('persons.create', compact('mappingTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'identifier' => 'required|unique:2_persons,identifier',
            'label_en' => 'required',
            'birth_year' => 'nullable|integer',
            'death_year' => 'nullable|integer',
            'birth_year_uncertain' => 'boolean',
            'death_year_uncertain' => 'boolean',
            'legendary' => 'boolean',
        ]);

        $person = Person::create([
            'identifier' => $request->input('identifier'),
            'label_en' => $request->input('label_en'),
            'description_en' => $request->input('description_en'),
            'gnd_id' => $request->input('gnd_id'),
            'gnd_mapping' => $request->input('gnd_mapping'),
            'wikidata_id' => $request->input('wikidata_id'),
            'wikidata_mapping' => $request->input('wikidata_mapping'),
            'birth_year' => $request->input('birth_year'),
            'birth_year_uncertain' => $request->boolean('birth_year_uncertain'),
            'death_year' => $request->input('death_year'),
            'death_year_uncertain' => $request->boolean('death_year_uncertain'),
            'legendary' => $request->boolean('legendary'),
        ]);

        // Alternative Names speichern
        if ($request->has('alternative_names')) {
            foreach ($request->input('alternative_names') as $altName) {
                if (!empty($altName['name'])) {
                    AlternativeName::create([
                        'vocabulary_type' => 'person',
                        'vocabulary_id' => $person->id,
                        'name' => $altName['name'],
                        'language' => $altName['language'] ?? 'en',
                    ]);
                }
            }
        }

        return redirect()->route('persons.index')->with('success', 'Person created!');
    }

    public function show(Person $person)
    {
        $person->load(['games', 'alternativeNames']);

        return view('persons.show', compact('person'));
    }

    public function edit(Person $person)
    {
        $person->load('alternativeNames');
        $mappingTypes = ['exactMatch', 'closeMatch', 'broadMatch', 'narrowMatch', 'relatedMatch'];

        return view('persons.edit', compact('person', 'mappingTypes'));
    }

    public function update(Request $request, Person $person)
    {
        $request->validate([
            'identifier' => 'required|unique:2_persons,identifier,' . $person->id,
            'label_en' => 'required',
            'birth_year' => 'nullable|integer',
            'death_year' => 'nullable|integer',
            'birth_year_uncertain' => 'boolean',
            'death_year_uncertain' => 'boolean',
            'legendary' => 'boolean',
        ]);

        $person->update([
            'identifier' => $request->input('identifier'),
            'label_en' => $request->input('label_en'),
            'description_en' => $request->input('description_en'),
            'gnd_id' => $request->input('gnd_id'),
            'gnd_mapping' => $request->input('gnd_mapping'),
            'wikidata_id' => $request->input('wikidata_id'),
            'wikidata_mapping' => $request->input('wikidata_mapping'),
            'birth_year' => $request->input('birth_year'),
            'birth_year_uncertain' => $request->boolean('birth_year_uncertain'),
            'death_year' => $request->input('death_year'),
            'death_year_uncertain' => $request->boolean('death_year_uncertain'),
            'legendary' => $request->boolean('legendary'),
        ]);

        // Alternative Names aktualisieren
        $person->alternativeNames()->delete();
        if ($request->has('alternative_names')) {
            foreach ($request->input('alternative_names') as $altName) {
                if (!empty($altName['name'])) {
                    AlternativeName::create([
                        'vocabulary_type' => 'person',
                        'vocabulary_id' => $person->id,
                        'name' => $altName['name'],
                        'language' => $altName['language'] ?? 'en',
                    ]);
                }
            }
        }

        return redirect()->route('persons.index')->with('success', 'Person updated!');
    }

    public function destroy(Person $person)
    {
        $person->alternativeNames()->delete();
        $person->games()->detach();
        $person->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Search GND API for persons
     */
    public function gndSearch(Request $request)
    {
        $query = $request->input('q');

        if (empty($query)) {
            return response()->json([]);
        }

        $response = Http::get('https://lobid.org/gnd/search', [
            'q' => $query,
            'filter' => 'type:Person',
            'size' => 10,
            'format' => 'json',
        ]);

        if ($response->failed()) {
            return response()->json([]);
        }

        $results = collect($response->json()['member'] ?? [])->map(function ($item) {
            $lifespan = '';
            if (isset($item['dateOfBirth'][0]) || isset($item['dateOfDeath'][0])) {
                $birth = $item['dateOfBirth'][0] ?? '?';
                $death = $item['dateOfDeath'][0] ?? '?';
                $lifespan = " ({$birth} – {$death})";
            }

            return [
                'gnd_id' => $item['gndIdentifier'] ?? null,
                'name' => ($item['preferredName'] ?? 'Unknown') . $lifespan,
                'description' => implode('; ', array_slice($item['professionOrOccupation'] ?? [], 0, 3)),
            ];
        });

        return response()->json($results);
    }
}
