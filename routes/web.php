<?php

use App\Livewire\User\Contacts;
use App\Livewire\User\Questions;
use App\Livewire\ContactFlow;
use App\Livewire\Documentation;
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

Route::view('/','home')->name('home');

// Contact pagina met mail
Route::view('contact','contact')->name('contact');
Route::get('contactflow',ContactFlow::class)->name('contactflow');
Route::get('documentation',Documentation::class)->name('documentation');

// CRUD pagina om contacten te beheren
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('contacts', Contacts::class)->name('contacts');
    Route::get('questions', Questions::class)->name('questions');
});

/*
  // CRUD pagina om contacten te beheren
Route::middleware(['auth', 'admin'])->prefix('user')->name('user.')->group(function () {
    Route::get('contacts', Contacts::class)->name('contacts');
});

 * */
Route::view('under-construction', 'under-construction')->name('under-construction');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
