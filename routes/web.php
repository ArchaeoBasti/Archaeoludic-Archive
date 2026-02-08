<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\GameplayModeController;
use App\Http\Controllers\PlayerRoleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BibliographyController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\TropeController;
use App\Http\Controllers\PersonController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/bibliography', [BibliographyController::class, 'index'])->name('bibliography');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::view('/imprint', 'imprint')->name('imprint');
Route::view('/privacy', 'privacy')->name('privacy');

// Tropes Routes
Route::resource('tropes', TropeController::class);

// Persons Routes - GND Search MUSS VOR resource() stehen!
Route::get('/persons/gnd-search', [PersonController::class, 'gndSearch'])->name('persons.gnd-search');
Route::resource('persons', PersonController::class);

// Vocabulary Routes
Route::resource('periods', PeriodController::class);
Route::resource('places', PlaceController::class);
Route::resource('gameplay-modes', GameplayModeController::class);
Route::resource('player-roles', PlayerRoleController::class);

// Public Vocabulary Routes
Route::get('/periods', [PeriodController::class, 'index'])->name('periods.index');
Route::get('/periods/{period}', [PeriodController::class, 'show'])->name('periods.show');

Route::get('/places', [PlaceController::class, 'index'])->name('places.index');
Route::get('/places/{place}', [PlaceController::class, 'show'])->name('places.show');

Route::get('/gameplay-modes', [GameplayModeController::class, 'index'])->name('gameplay-modes.index');
Route::get('/gameplay-modes/{gameplayMode}', [GameplayModeController::class, 'show'])->name('gameplay-modes.show');

Route::get('/player-roles', [PlayerRoleController::class, 'index'])->name('player-roles.index');
Route::get('/player-roles/{playerRole}', [PlayerRoleController::class, 'show'])->name('player-roles.show');

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
    Route::post('/developer', [GameController::class, 'createDeveloper'])->name('developer.store');
    Route::post('/games/{id}/literature', [GameController::class, 'addLiterature'])->name('games.addLiterature');
    Route::delete('/games/{id}/literature/{literatureId}', [GameController::class, 'removeLiterature'])->name('games.removeLiterature');
    Route::delete('/games/{id}', [GameController::class, 'destroy'])->name('games.destroy');

    // Game Vocabulary Routes (Periods)
    Route::post('/games/{id}/periods', [GameController::class, 'addPeriod'])->name('games.addPeriod');
    Route::delete('/games/{id}/periods/{periodId}', [GameController::class, 'removePeriod'])->name('games.removePeriod');

    // Game Vocabulary Routes (Places)
    Route::post('/games/{id}/places', [GameController::class, 'addPlace'])->name('games.addPlace');
    Route::delete('/games/{id}/places/{placeId}', [GameController::class, 'removePlace'])->name('games.removePlace');

    // Game Vocabulary Routes (Gameplay Modes)
    Route::post('/games/{id}/gameplay-modes', [GameController::class, 'addGameplayMode'])->name('games.addGameplayMode');
    Route::delete('/games/{id}/gameplay-modes/{modeId}', [GameController::class, 'removeGameplayMode'])->name('games.removeGameplayMode');

    // Game Vocabulary Routes (Player Roles)
    Route::post('/games/{id}/player-roles', [GameController::class, 'addPlayerRole'])->name('games.addPlayerRole');
    Route::delete('/games/{id}/player-roles/{roleId}', [GameController::class, 'removePlayerRole'])->name('games.removePlayerRole');

    // Trope methods for games
    Route::post('/games/{id}/trope', [GameController::class, 'addTrope'])->name('games.addTrope');
    Route::delete('/games/{id}/trope/{tropeId}', [GameController::class, 'removeTrope'])->name('games.removeTrope');

    // Person methods for games
    Route::post('/games/{id}/person', [GameController::class, 'addPerson'])->name('games.addPerson');
    Route::delete('/games/{id}/person/{personId}', [GameController::class, 'removePerson'])->name('games.removePerson');
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
    // Periods
    Route::get('/periods/create', [PeriodController::class, 'create'])->name('periods.create');
    Route::post('/periods', [PeriodController::class, 'store'])->name('periods.store');
    Route::get('/periods/{period}/edit', [PeriodController::class, 'edit'])->name('periods.edit');
    Route::put('/periods/{period}', [PeriodController::class, 'update'])->name('periods.update');
    Route::delete('/periods/{period}', [PeriodController::class, 'destroy'])->name('periods.destroy');

    // Places
    Route::get('/places/create', [PlaceController::class, 'create'])->name('places.create');
    Route::post('/places', [PlaceController::class, 'store'])->name('places.store');
    Route::get('/places/{place}/edit', [PlaceController::class, 'edit'])->name('places.edit');
    Route::put('/places/{place}', [PlaceController::class, 'update'])->name('places.update');
    Route::delete('/places/{place}', [PlaceController::class, 'destroy'])->name('places.destroy');

    // Gameplay Modes
    Route::get('/gameplay-modes/create', [GameplayModeController::class, 'create'])->name('gameplay-modes.create');
    Route::post('/gameplay-modes', [GameplayModeController::class, 'store'])->name('gameplay-modes.store');
    Route::get('/gameplay-modes/{gameplayMode}/edit', [GameplayModeController::class, 'edit'])->name('gameplay-modes.edit');
    Route::put('/gameplay-modes/{gameplayMode}', [GameplayModeController::class, 'update'])->name('gameplay-modes.update');
    Route::delete('/gameplay-modes/{gameplayMode}', [GameplayModeController::class, 'destroy'])->name('gameplay-modes.destroy');

    // Player Roles
    Route::get('/player-roles/create', [PlayerRoleController::class, 'create'])->name('player-roles.create');
    Route::post('/player-roles', [PlayerRoleController::class, 'store'])->name('player-roles.store');
    Route::get('/player-roles/{playerRole}/edit', [PlayerRoleController::class, 'edit'])->name('player-roles.edit');
    Route::put('/player-roles/{playerRole}', [PlayerRoleController::class, 'update'])->name('player-roles.update');
    Route::delete('/player-roles/{playerRole}', [PlayerRoleController::class, 'destroy'])->name('player-roles.destroy');

    // ... deine anderen auth-geschützten Routes
});

Route::get('/api/igdb-search', [GameController::class, 'igdbSearch'])->name('igdb.search');
Route::get('/api/wikidata-search', [GameController::class, 'wikidataSearch'])->name('wikidata.search');
Route::get('/api/zotero-search', [GameController::class, 'zoteroSearch'])->name('zotero.search');

require __DIR__.'/auth.php';
