<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
Route::post('/home/update', [App\Http\Controllers\HomeController::class, 'update'])->name('home.update');
Route::get('/check', [App\Http\Controllers\HomeController::class, 'check'])->name('check');
Route::get('/mypage', [App\Http\Controllers\HomeController::class, 'mypage'])->name('mypage');
Route::get('/location_list', [App\Http\Controllers\HomeController::class, 'locationList'])->name('location_list');

Route::get('/practice', [App\Http\Controllers\PracticeController::class, 'practice'])->name('practice');
Route::post('/practice', [App\Http\Controllers\PracticeController::class, 'post'])->name('practice.post');
Route::get('/practice/location', [App\Http\Controllers\PracticeController::class, 'location'])->name('practice.location');
Route::post('/practice/location', [App\Http\Controllers\PracticeController::class, 'send'])->name('practice.send');
Route::get('/practice/complete/{ym}', [App\Http\Controllers\PracticeController::class, 'complete'])->name('practice.complete');

Route::get('/list', [App\Http\Controllers\ListController::class, 'list'])->name('list');
Route::get('/list/{ym}', [App\Http\Controllers\ListController::class, 'detail'])->name('list.detail');
Route::post('/list/update', [App\Http\Controllers\ListController::class, 'update'])->name('list.update');
Route::post('/list/delete/{id}', [App\Http\Controllers\ListController::class, 'delete'])->name('list.delete');
Route::post('/list/reason', [App\Http\Controllers\ListController::class, 'reason'])->name('list.reason');

