@extends('layouts.baseview')

@section('title', $project->name)

@section('button-projects-type', "btn-dark")
@section('button-tasks-type', "btn-primary")
@section('button-users-type', "btn-primary")
@section('button-settings-type', "btn-primary")

@section('left-nav')
		<form action="/projects" method="GET"><button id="btn-all-projects" type="submit" class="btn btn-md btn-outline-primary btn-left-nav"><i class="fa fa-table mr-2"></i>All Projects</button></form>
		<button id="btn-project-dashboard" type="button" class="btn btn-md btn-outline-primary btn-left-nav"><i class="fa fa-tachometer mr-2"></i>Dashboard</button>
		<button id="btn-project-tasks" type="button" class="btn btn-md btn-outline-primary btn-left-nav"><i class="fa fa-tasks mr-2"></i>Tasks</button>
		<button id="btn-project-notes" type="button" class="btn btn-md btn-outline-primary btn-left-nav"><i class="fa fa-pencil-square-o mr-2"></i>Notes</button>		
@endsection

@section('content')

	<div class="projectview-grid-container">

		<div class="card fragment pv-summary">
			test content
		</div>

		<div class="card fragment pv-notes-summary">
			test content notes
		</div>

		<div class="card fragment pv-tasks-summary">
			test content tasks
		</div>
		
	</div>

@endsection

@section('javascript')

@endsection