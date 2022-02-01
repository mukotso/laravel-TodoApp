<?php

use Illuminate\Support\Facades\Route;
Use App\Http\Controllers\PostsController;

Use App\Http\Controllers\TodosController;


Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

//resource
Route::resource('todo', TodosController::class);
Route::get('todos/search', [\App\Http\Controllers\TodosController::class, 'search'])->name('todo.search');
Route::get('todos/{id}/complete', [\App\Http\Controllers\TodosController::class, 'completeTodo'])->name('todo.complete');


//posts
//Route::resource('posts', PostsController::class);
Route::get('posts', [\App\Http\Controllers\PostsController::class, 'index'])->name('posts.index');
Route::get('posts/getPosts', [\App\Http\Controllers\PostsController::class, 'getPosts']);
