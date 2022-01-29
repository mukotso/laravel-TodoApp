<?php

use Illuminate\Support\Facades\Route;
Use App\Http\Controllers\TodosController;
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

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

//resource
Route::resource('todo', TodosController::class);
Route::get('todos/search', [\App\Http\Controllers\TodosController::class, 'search'])->name('todo.search');
Route::get('todos/{id}/complete', [\App\Http\Controllers\TodosController::class, 'completeTodo'])->name('todo.complete');
