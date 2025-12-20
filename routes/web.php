<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VocabularyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BibliographyController;
use App\Http\Controllers\AboutController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/vocabulary', [VocabularyController::class, 'index'])->name('vocabulary');
Route::get('/bibliography', [BibliographyController::class, 'index'])->name('bibliography');
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Öffentliche Games-Routen
Route::get('/games', [GameController::class, 'index'])->name('games');

// Auth-geschützte Games-Routen - MÜSSEN vor /games/{id} stehen!
Route::middleware('auth')->group(function () {
    Route::get('/games/create', [GameController::class, 'create'])->name('games.create');
    Route::post('/games', [GameController::class, 'store'])->name('games.store');
    Route::get('/games/{id}/edit', [GameController::class, 'edit'])->name('games.edit');
    Route::put('/games/{id}', [GameController::class, 'update'])->name('games.update');
    Route::post('/games/{id}/developer', [GameController::class, 'addDeveloper'])->name('games.addDeveloper');
    Route::delete('/games/{id}/developer/{developerId}', [GameController::class, 'removeDeveloper'])->name('games.removeDeveloper');
    Route::post('/developer', [GameController::class, 'createDeveloper'])->name('developer.create');
    Route::post('/games/{id}/literature', [GameController::class, 'addLiterature'])->name('games.addLiterature');
    Route::delete('/games/{id}/literature/{literatureId}', [GameController::class, 'removeLiterature'])->name('games.removeLiterature');
    Route::delete('/games/{id}', [GameController::class, 'destroy'])->name('games.destroy');
    Route::post('/games/{id}/vocabulary', [GameController::class, 'addVocabulary'])->name('games.addVocabulary');
    Route::delete('/games/{id}/vocabulary/{vocId}', [GameController::class, 'removeVocabulary'])->name('games.removeVocabulary');
});

// Diese Route MUSS nach /games/create kommen!
Route::get('/games/{id}', [GameController::class, 'show'])->name('games.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/vocabulary/create', [VocabularyController::class, 'create'])->name('vocabulary.create');
    Route::post('/vocabulary', [VocabularyController::class, 'store'])->name('vocabulary.store');
    Route::get('/vocabulary/{id}/edit', [VocabularyController::class, 'edit'])->name('vocabulary.edit');
    Route::put('/vocabulary/{id}', [VocabularyController::class, 'update'])->name('vocabulary.update');
    Route::delete('/vocabulary/{id}', [VocabularyController::class, 'destroy'])->name('vocabulary.destroy');
});

Route::get('/api/igdb-search', [GameController::class, 'igdbSearch'])->name('igdb.search');
Route::get('/api/wikidata-search', [GameController::class, 'wikidataSearch'])->name('wikidata.search');
Route::get('/api/zotero-search', [GameController::class, 'zoteroSearch'])->name('zotero.search');

require __DIR__.'/auth.php';
