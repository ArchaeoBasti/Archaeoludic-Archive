<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Vocabulary;

class VocabularyController extends Controller
{
    public function index()
    {
        $vocabularies = DB::table('2_vocabulary')
            ->orderBy('category')
            ->orderBy('voc_id')
            ->get();

        $categories = $vocabularies->groupBy('category');

        return view('vocabulary.index', compact('vocabularies', 'categories'));
    }

    public function create()
    {
        $nextId = $this->generateNextId();
        $categories = DB::table('2_vocabulary')
            ->select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category');

        return view('vocabulary.create', compact('nextId', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'voc_id' => 'required|unique:2_vocabulary,voc_id',
            'term' => 'required',
        ]);

        Vocabulary::create([
            'voc_id' => $request->input('voc_id'),
            'term' => $request->input('term'),
            'description' => $request->input('description'),
            'category' => $request->input('category'),
        ]);

        return redirect()->route('vocabulary')->with('success', 'Vocabulary entry created!');
    }

    public function edit($id)
    {
        $vocabulary = DB::table('2_vocabulary')->where('voc_id', $id)->first();

        if (!$vocabulary) {
            abort(404);
        }

        $categories = DB::table('2_vocabulary')
            ->select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category');

        return view('vocabulary.edit', compact('vocabulary', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'term' => 'required',
        ]);

        DB::table('2_vocabulary')
            ->where('voc_id', $id)
            ->update([
                'term' => $request->input('term'),
                'description' => $request->input('description'),
                'category' => $request->input('category'),
                'updated_at' => now(),
            ]);

        return redirect()->route('vocabulary')->with('success', 'Vocabulary entry updated!');
    }

    public function destroy($id)
    {
        DB::table('1_game_vocabulary')->where('voc_id', $id)->delete();
        DB::table('2_vocabulary')->where('voc_id', $id)->delete();

        return response()->json(['success' => true]);
    }

    protected function generateNextId()
    {
        $lastEntry = DB::table('2_vocabulary')
            ->orderBy('voc_id', 'desc')
            ->first();

        if (!$lastEntry) {
            return 'voc0001';
        }

        $lastNumber = (int) substr($lastEntry->voc_id, 3);
        $nextNumber = $lastNumber + 1;

        return 'voc' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
