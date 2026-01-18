<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameplayMode;

class GameplayModeController extends Controller
{
    public function index()
    {
        $gameplayModes = GameplayMode::orderBy('label_en')->get();

        return view('gameplay-modes.index', compact('gameplayModes'));
    }

    public function create()
    {
        return view('gameplay-modes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'identifier' => 'required|unique:2_gameplay_modes,identifier',
            'label_en' => 'required',
        ]);

        GameplayMode::create([
            'identifier' => $request->input('identifier'),
            'label_en' => $request->input('label_en'),
            'description_en' => $request->input('description_en'),
        ]);

        return redirect()->route('gameplay-modes.index')->with('success', 'Gameplay mode created!');
    }

    public function show(GameplayMode $gameplayMode)
    {
        $gameplayMode->load(['games.igdb', 'alternativeNames']);

        return view('gameplay-modes.show', compact('gameplayMode'));
    }

    public function edit(GameplayMode $gameplayMode)
    {
        $gameplayMode->load('alternativeNames');
        return view('gameplay-modes.edit', compact('gameplayMode'));
    }

    public function update(Request $request, GameplayMode $gameplayMode)
    {
        $request->validate([
            'identifier' => 'required|unique:2_gameplay_modes,identifier,' . $gameplayMode->id,
            'label_en' => 'required',
        ]);

        $gameplayMode->update([
            'identifier' => $request->input('identifier'),
            'label_en' => $request->input('label_en'),
            'description_en' => $request->input('description_en'),
        ]);

        return redirect()->route('gameplay-modes.index')->with('success', 'Gameplay mode updated!');
    }

    public function destroy(GameplayMode $gameplayMode)
    {
        $gameplayMode->games()->detach();
        $gameplayMode->mappings()->delete();
        $gameplayMode->delete();

        return response()->json(['success' => true]);
    }
}
