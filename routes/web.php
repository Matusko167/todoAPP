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


Route::get('/tasks', 'App\Http\Controllers\TasksController@index');
Route::post('/tasks', 'App\Http\Controllers\TasksController@store')->name('tasks.store')->middleware('web');
Route::post('/tasks/{task}', 'App\Http\Controllers\TasksController@makeDone')->name('tasks.makeDone');
Route::post('/tasks/share/{task}', 'App\Http\Controllers\TasksController@share')->name('tasks.share')->middleware('web');
Route::get('/tasks/filter', 'App\Http\Controllers\TasksController@filter')->name('tasks.filter')->middleware('web');


Auth::routes();
