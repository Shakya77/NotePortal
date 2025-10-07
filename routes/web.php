<?php

use App\Http\Controllers\Guest\GuestController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Website\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('{slug}/{default?}', [GuestController::class, 'index'])->name('default');
Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
Route::get('/notes/{id}', [NoteController::class, 'show'])->name('notes.show');

Route::get('/tutorials', function () {
    dd('hello');
})->name('tutorials');

Route::get('/exercises', function () {
    dd('hello');
})->name('exercises');

Route::get('/references', function () {
    dd('hello');
})->name('references');
