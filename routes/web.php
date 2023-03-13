<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\HomeController as GuestHomeController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TypeController;

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

// GUEST ROUTES
Route::get('/', [GuestHomeController::class, 'index']);

// ADMINISTRATION PROTECTED ROUTES
Route::middleware(['auth', 'verified'])->name('admin.')->prefix('admin')->group(function() {
    // ADMINISTRATION HOME
    Route::get('/', [AdminHomeController::class, 'index'])->name('home');
    // ROUTES PROJECT CRUD
    Route::resource('projects', ProjectController::class);
    // ROUTES TYPE CRUD
    Route::resource('types', TypeController::class);
    // ROUTE TOGGLE
    Route::patch('/projects/{project}/toggle', [ProjectController::class, 'toggle'])->name('projects.toggle');


    /* CRUD list
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy'); 
    */
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::resource('admin/technologies', App\Http\Controllers\Admin\TechnologyController::class, ['as' => 'admin']);