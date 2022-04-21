<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;

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

Route::get('/tasks', 'App\Http\Controllers\TasksController@index');
Route::post('/tasks', 'App\Http\Controllers\TasksController@store');
Route::delete('/tasks/{task}', 'App\Http\Controllers\TasksController@destroy');
Route::post('/tasks/{task}', 'App\Http\Controllers\TasksController@makeDone')->name('tasks.makeDone');
Route::post('/tasks/share/{task}', 'App\Http\Controllers\TasksController@share')->name('tasks.share');

