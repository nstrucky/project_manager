@extends('layouts.app')

@section('left-nav')
		<form action="/projects" method="GET"><button id="btn-all-projects" type="submit" class="btn btn-md btn-outline-primary btn-left-nav"><i class="fa fa-table mr-2"></i>All Projects</button></form>
		<button id="btn-project-dashboard" type="button" class="btn btn-md btn-outline-primary btn-left-nav"><i class="fa fa-tachometer mr-2"></i>Dashboard</button>
		<button id="btn-project-tasks" type="button" class="btn btn-md btn-outline-primary btn-left-nav"><i class="fa fa-tasks mr-2"></i>Tasks</button>
		<button id="btn-project-notes" type="button" class="btn btn-md btn-outline-primary btn-left-nav"><i class="fa fa-pencil-square-o mr-2"></i>Notes</button>		
@endsection

@section('content')

	<div class="projectview-grid-container" id="view-dashboard">
		<div class="card pv-summary">
			<header class="card-header">
				<font>Summary</font>
			</header>
			<div class="subgrid card-body" >

				<div>
					<label for="input-project-name">Project Name</label>
					<input type="text" id="input-project-name" class="form-control" maxlength="25" disabled="" value="{{$project->name}}">
					<label for="input-account-name">Account Name</label>
					<input type="text" id="input-account-name" class="form-control" maxlength="25" disabled="" value="{{$project->account_name}}">

				</div>
				<div>
					<label for="input-project-status">Project Status</label>
					<select class="form-control" id="input-project-status" disabled="">
						@foreach($status_codes as $code)
							<?php $selected = strcmp($project->status,$code->name) == 0; ?>
							<option {{$selected ? 'selected' : ''}}>{{$code->name}}</option>
	            		@endforeach
	          		</select>
					<label for="input-workorder">Work Order</label>
					<input type="text" id="input-workorder" class="form-control" maxlength="6" disabled="" value="{{$project->work_order}}">

				</div>

				<div>
					<label for="input-account-number">Account Number</label>
					<input type="text" id="input-account-number" class="form-control" maxlength="6" disabled="" value="{{$project->account_number}}">					
					<label for="input-due-date">Due Date</label>
					<input type="date" id="input-due-date" class="form-control" disabled="" value="{{$project->due_date}}">
				</div>

				<div style="grid-column-end: span 3;">
					<label for="input-description">Description</label>
					<textarea id="input-description" class="form-control textarea-md" rows="3" style="width: 100%; overflow-y: auto;" disabled="">{{$project->description}}</textarea>
				</div>
				
			</div>
		</div>

		<div class="card pv-notes-summary" style="word-wrap: normal; overflow: auto;">
			<header class="card-header">
				<font>Notes</font>
				
			</header>
			<button class="btn btn-success btn-sm"><i class="fa fa-plus mr-2"></i>Add Note</button>
			<div class="card-body" style="overflow-y: auto; max-height: 800px;">

				@foreach($notes as $note)
				<div>
					<p class="notes-box">{{$note->content}}</p>
					<footer style="border-bottom: 1px solid #cccccc;">
						<font size="2" style="margin-left: 10px;">{{date_format(new DateTime($note->created_at), 'm/d/Y H:m:s')}}</font>
					</footer>
					
				</div>
						
				@endforeach				
			</div>

		</div>

		<div class="card pv-tasks-summary">
			<header class="card-header">
				<font>Tasks</font>
			</header>
			<div class="card-body">
				<table class="table table-striped table-bordered table-sm" id="tasksTable" style="width: 100%">
				<thead>
					<tr>
						<th>Completed</th>
						<th>Task</th>
						<th>Owner</th>
						<th>Due Date</th>
					</tr>
				</thead>
				<tbody>
					@foreach($tasks as $task)

						<?php
							$completed = $task->completed == 1;
          					$datetime1 = new DateTime($task->due_date);
							$datetime2 = new DateTime(today());
							$isOverDue = ($datetime1 <= $datetime2 && !$completed);
						 ?>

						<tr style="background-color: {{$isOverDue ? '#f29d9d' : ''}}">
							<td><button type="button" style="border-radius: 25px; margin: auto; width: 100%;" class="btn btn-sm btn-{{$completed ? 'success' : 'warning'}}">{{ $completed ? 'Complete' : 'In Progress'}}</button>
							</td>
							<td>{{$task->title}}</td>
							<td>
								<?php $user = $task->user ?>
								{{$user->first_name . ' ' . $user->last_name}}
							</td>
							<td>
								<?php $datestring = date_format(new DateTime($task->due_date), 'm/d/Y'); ?>
								{{ $datestring }}
							</td>
						</tr>
					@endforeach
					
				</tbody>
			</table>
			</div>
			
		</div>
		
	</div>

@endsection

@section('javascript')

    {{-- Format Table --}}
    <script>
      $(document).ready(function () {
        $('#tasksTable').DataTable({
          "scrollY": "300px",
          "scrollCollapse": true,
          "searching" : false
        });
        $('.dataTables_length').addClass('bs-select');
      });
    </script>
@endsection