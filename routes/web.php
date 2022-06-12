<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PerizinanController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['role:staf|manager']], function () {
    Route::resource('/perizinan', PerizinanController::class);
});
Route::group(['middleware' => ['role:manager']], function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('/approval', [App\Http\Controllers\PerizinanController::class, 'approval'])->name('approval');
    Route::put('/approval/{id}/approve', [PerizinanController::class, 'approve'])->name('approve');
    Route::put('/tolak/{id}/tolak', [PerizinanController::class, 'tolak'])->name('tolak');
});
