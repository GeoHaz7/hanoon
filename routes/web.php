<?php

use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('layouts.app');
});

Route::get('/data', function () {
    return view('component.datatable');
});


//get Data
Route::get('/news/data', [NewsController::class, 'index'])->name('news.data');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//add news form
Route::get('/news/add', [App\Http\Controllers\NewsController::class, 'addNewsForm'])->name('addNewsForm');

//store news form
Route::post('/news/store', [App\Http\Controllers\NewsController::class, 'storeNews'])->name('storeNews');

//edit news form
Route::get('/news/{id}/edit', [App\Http\Controllers\NewsController::class, 'editNewsForm'])->name('editNewsForm');
