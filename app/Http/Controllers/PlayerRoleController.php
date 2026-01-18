<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlayerRole;

class PlayerRoleController extends Controller
{
    public function index()
    {
        $playerRoles = PlayerRole::orderBy('label_en')->get();

        return view('player-roles.index', compact('playerRoles'));
    }

    public function create()
    {
        return view('player-roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'identifier' => 'required|unique:2_player_roles,identifier',
            'label_en' => 'required',
        ]);

        PlayerRole::create([
            'identifier' => $request->input('identifier'),
            'label_en' => $request->input('label_en'),
            'description_en' => $request->input('description_en'),
        ]);

        return redirect()->route('player-roles.index')->with('success', 'Player role created!');
    }

    public function show(PlayerRole $playerRole)
    {
        $playerRole->load(['games.igdb', 'alternativeNames']);

        return view('player-roles.show', compact('playerRole'));
    }

    public function edit(PlayerRole $playerRole)
    {
        $playerRole->load('alternativeNames');
        return view('player-roles.edit', compact('playerRole'));
    }

    public function update(Request $request, PlayerRole $playerRole)
    {
        $request->validate([
            'identifier' => 'required|unique:2_player_roles,identifier,' . $playerRole->id,
            'label_en' => 'required',
        ]);

        $playerRole->update([
            'identifier' => $request->input('identifier'),
            'label_en' => $request->input('label_en'),
            'description_en' => $request->input('description_en'),
        ]);

        return redirect()->route('player-roles.index')->with('success', 'Player role updated!');
    }

    public function destroy(PlayerRole $playerRole)
    {
        $playerRole->games()->detach();
        $playerRole->mappings()->delete();
        $playerRole->delete();

        return response()->json(['success' => true]);
    }
}
