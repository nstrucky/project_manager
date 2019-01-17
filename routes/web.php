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

Route::get('/', function () {
        $projects = \App\Project::all();
        $status_codes = \App\StatusCode::all();

        return view('project.projects', [
            'projects' => $projects,
            'status_codes' => $status_codes
        ]);
});

Route::resource('/projects', 'ProjectsController');
Route::resource('/tasks', 'TasksController');
Route::resource('/notes', 'NotesController');
Route::get('/projects/{project}/notes', 'NotesController@projectNotes');
