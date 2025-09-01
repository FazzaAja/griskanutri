<?php

use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\ResepController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LandingPageController;

Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::get('/kurikulum', [LandingPageController::class, 'showKurikulum'])->name('kurikulum.index');
Route::get('/materi/{materi:slug}', [LandingPageController::class, 'showMateri'])->name('materi.show');
Route::get('/jelajah-resep', [LandingPageController::class, 'indexResep'])->name('resep.index');
Route::get('/resep/{resep:slug}', [LandingPageController::class, 'showResep'])->name('resep.show');

// Rute untuk Kuis dengan Tampilan Google Form
Route::get('/materi/{materi:slug}/latihan', [LandingPageController::class, 'showQuiz'])->name('latihan.show');
Route::post('/materi/{materi:slug}/latihan', [LandingPageController::class, 'submitQuiz'])->name('latihan.submit');
Route::get('/materi/{materi:slug}/hasil', [LandingPageController::class, 'showResult'])->name('latihan.result');

// Route::get('/', function () {
//     return view('welcome');
// });
Route::middleware('auth')->group(function () {
    Route::resource('kurikulums', KurikulumController::class);
    Route::resource('materis', MateriController::class);
    Route::resource('materis.soals', SoalController::class);

    // Rute untuk Kuis
    Route::get('/materis/{materi:slug}/quiz', [MateriController::class, 'quiz'])->name('materis.quiz');
    Route::post('/materis/{materi:slug}/quiz', [MateriController::class, 'submitQuiz'])->name('materis.submitQuiz');
    Route::get('/materis/{materi:slug}/result', [MateriController::class, 'result'])->name('materis.result');

    Route::resource('reseps', ResepController::class);
    Route::get('/reseps/autocomplete', [ResepController::class, 'autocomplete'])->name('reseps.autocomplete');
});
