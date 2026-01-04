<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Period;

class PeriodController extends Controller
{
    public function index()
    {
        $periods = Period::with(['parent', 'children.children'])
            ->orderBy('start_year')
            ->orderBy('label_en')
            ->get();

        $topLevelPeriods = $periods->whereNull('parent_id');

        return view('periods.index', compact('periods', 'topLevelPeriods'));
    }

    public function create()
    {
        $parentOptions = Period::with('parent')
            ->orderBy('start_year')
            ->get();

        return view('periods.create', compact('parentOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'identifier' => 'required|unique:2_periods,identifier',
            'label_en' => 'required',
            'start_year' => 'nullable|integer',
            'end_year' => 'nullable|integer',
        ]);

        Period::create([
            'identifier' => $request->input('identifier'),
            'label_en' => $request->input('label_en'),
            'description_en' => $request->input('description_en'),
            'parent_id' => $request->input('parent_id'),
            'start_year' => $request->input('start_year'),
            'end_year' => $request->input('end_year'),
            'start_uncertain' => $request->boolean('start_uncertain'),
            'end_uncertain' => $request->boolean('end_uncertain'),
        ]);

        return redirect()->route('periods.index')->with('success', 'Period created!');
    }

    public function show(Period $period)
    {
        $period->load(['parent', 'children', 'games.igdb', 'mappings']);

        return view('periods.show', compact('period'));
    }

    public function edit(Period $period)
    {
        // Alle Nachfahren des aktuellen Periods sammeln (um Zirkelbezüge zu vermeiden)
        $excludeIds = collect([$period->id]);
        $childIds = Period::where('parent_id', $period->id)->pluck('id');
        $excludeIds = $excludeIds->merge($childIds);
        // Auch Enkel ausschließen
        $grandchildIds = Period::whereIn('parent_id', $childIds)->pluck('id');
        $excludeIds = $excludeIds->merge($grandchildIds);

        $parentOptions = Period::with('parent')
            ->whereNotIn('id', $excludeIds)
            ->orderBy('start_year')
            ->get();

        return view('periods.edit', compact('period', 'parentOptions'));
    }

    public function update(Request $request, Period $period)
    {
        $request->validate([
            'identifier' => 'required|unique:2_periods,identifier,' . $period->id,
            'label_en' => 'required',
            'start_year' => 'nullable|integer',
            'end_year' => 'nullable|integer',
        ]);

        $period->update([
            'identifier' => $request->input('identifier'),
            'label_en' => $request->input('label_en'),
            'description_en' => $request->input('description_en'),
            'parent_id' => $request->input('parent_id'),
            'start_year' => $request->input('start_year'),
            'end_year' => $request->input('end_year'),
            'start_uncertain' => $request->boolean('start_uncertain'),
            'end_uncertain' => $request->boolean('end_uncertain'),
        ]);

        return redirect()->route('periods.index')->with('success', 'Period updated!');
    }

    public function destroy(Period $period)
    {
        $period->games()->detach();
        $period->mappings()->delete();
        $period->delete();

        return response()->json(['success' => true]);
    }
}
