@extends('baseview')

@section('title', 'Projects')

@section('button-projects-type', "btn-dark")
@section('button-tasks-type', "btn-primary")
@section('button-users-type', "btn-primary")
@section('button-settings-type', "btn-primary")

@section('left-nav')

	<div role="group" class="button-group left-nav-btn-group">
		<button type="button" class="btn btn-md btn-default btn-outline"><i class="fa fa-plus-circle mr-2"></i>New Project</button>
		<button type="button" class="btn btn-md btn-primary"><i class="fa fa-table mr-2"></i>All Projects</button>
		<button type="button" class="btn btn-md btn-primary"><i class="fa fa-pencil-square-o mr-2"></i>Latest Notes</button>
	</div>

@endsection
@section('content')


@endsection