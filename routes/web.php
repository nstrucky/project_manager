<?php

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

// Route::get('/', function () {
//         $projects = \App\Project::all();
//         $status_codes = \App\StatusCode::all();

//         return view('project.projects', [
//             'projects' => $projects,
//             'status_codes' => $status_codes
//         ]);
// });

// Route::get('/', 'PagesController@home');
Route::resource('/projects', 'ProjectsController')->middleware('auth');
Route::resource('/tasks', 'TasksController')->middleware('auth');
Route::resource('/notes', 'NotesController')->middleware('auth');
Route::get('/projects/{project}/notes', 'NotesController@projectNotes')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index');
