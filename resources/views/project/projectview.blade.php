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

	<div class="projectview-grid-container" id="view-dashboard">

		<div class="card fragment pv-summary" >
			This is going to be some really long content like I have a lot to say here hopefully its not too much trouble I just dont want this to go unsaid! Anyway I was telling marge that I went to the store last week and saw Jimmy but he didnt wave at me what a jerk
		</div>

		<div class="card fragment pv-notes-summary" style="word-wrap: normal; overflow: auto;">
			@foreach($notes as $note)
			<div style="word-wrap: normal;">
				{{date_format(new DateTime($note->created_at), 'm/d/Y H:m:s')}}
				<p style="">{{$note->content}}</p>
				
			</div>
					
			@endforeach
		</div>

		<div class="card fragment pv-tasks-summary">
			test tasks content
		</div>
		
	</div>

@endsection

@section('javascript')

    {{-- Format Table --}}
    <script>
      $(document).ready(function () {
        $('#projectsTable').DataTable({
          "scrollY": "300px",
          "scrollX": "250px",
          "scrollCollapse": true
        });
        $('.dataTables_length').addClass('bs-select');
      });
    </script>
@endsection