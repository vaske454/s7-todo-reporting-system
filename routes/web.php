<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserSelectionController;
use App\Http\Controllers\ReportController;

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

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Route to show the form
Route::get('select-user', [UserSelectionController::class, 'showForm'])
    ->middleware(['auth', 'admin'])
    ->name('select-user');

// Route to generate the report
Route::match(['get', 'post'], 'generate-report', [ReportController::class, 'generateReport'])
    ->middleware(['auth', 'admin'])
    ->name('generate-report');

require __DIR__.'/auth.php';
