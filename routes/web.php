<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Admin\FormsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PagesController::class, 'index']);
Route::get('/setup', [SetupController::class, 'setupPage']);
Route::post('/setup', [SetupController::class, 'saveSetup'])->name('setup');

Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(
        function () {
            Route::resource('forms', FormsController::class);
        }
    );


Auth::routes([
    'reset' => false,
    'verify' => false
]);

Route::get('/home', [DashboardController::class, 'index'])->name('home');
