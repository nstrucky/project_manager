@extends('layouts.baseview')

@section('title', 'Projects')

@section('button-projects-type', "btn-dark")
@section('button-tasks-type', "btn-primary")
@section('button-users-type', "btn-primary")
@section('button-settings-type', "btn-primary")

@section('left-nav')
		<button id="btn-create-project" type="button" class="btn btn-md btn-outline-default btn-left-nav"><i class="fa fa-plus-circle mr-2"></i>New Project</button>
		<button id="btn-all-projects" type="button" class="btn btn-md btn-outline-primary btn-left-nav"><i class="fa fa-table mr-2"></i>All Projects</button>
		<button id="btn-project-notes" type="button" class="btn btn-md btn-outline-primary btn-left-nav"><i class="fa fa-pencil-square-o mr-2"></i>Notes</button>
@endsection

@section('content')

	<div class="card fragment" id="cardview-all-projects" style="margin: 25px;">
		<table class="table table-striped table-bordered table-sm" cellspacing="0" width="75%" id="projectsTable">
          <thead >
           <tr>
              <td>
              	<input id="search-projectid" type="text" class="form-control form-control-sm" onkeyup="searchTableData(0, 'projectsTable', 'search-projectid')"></td>
              <td>
              	<input id="search-workorder" type="text" class="form-control form-control-sm" onkeyup="searchTableData(1, 'projectsTable', 'search-workorder')">
              </td>
              <td>
          		<input id="search-project-name" type="text" class="form-control form-control-sm" onkeyup="searchTableData(2, 'projectsTable', 'search-project-name')">
              </td>
              <td>
              	<div>
                  <select class="form-control-sm" id="status_select" style="width: 100%" onchange="filterBySelect('status_select', 'projectsTable', 3)">
                    <option>All</option>

                    @foreach($status_codes as $code)
                    	<option>{{$code->name}}</option>
                    @endforeach
                  </select>
                </div>
              </td>
              <td>
              	<input id="search-accountname" type="text" class="form-control form-control-sm" onkeyup="searchTableData(4, 'projectsTable', 'search-accountname')">
              </td>
              <td>
              	<input id="search-accountnumber" type="text" class="form-control form-control-sm" onkeyup="searchTableData(5, 'projectsTable', 'search-accountnumber')">
              </td>
              <td>
              	<input id="search-duedate" type="text" class="form-control form-control-sm" onkeyup="searchTableData(6, 'projectsTable', 'search-duedate')">
              </td>
            </tr>
            <tr>
            	<th valign="middle" class="th-sm">Project ID</th>
            	<th class="th-sm">Work Order</th>
	            <th class="th-sm">Project Name</th>
	            <th class="th-sm">Status</th>
	            <th class="th-sm">Account</th>
	            <th class="th-sm">Account Number</th>
	            <th class="th-sm">Due Date</th>
            </tr>

            {{csrf_field()}}
          </thead>  
          <tbody>
          	@foreach($projects as $project)

          	<?php 
          		$statusName = $project->status;
          		$pillColor = \App\StatusCode::where('name', $statusName)->first()->hex_color;
          		$datetime1 = new DateTime($project->due_date);
				$datetime2 = new DateTime(today());
				$isOverDue = ($datetime1 <= $datetime2 && $statusName != 'Completed');
          	?>

          	<tr style="{{$isOverDue ? 'background-color: #f29d9d' : ''}} ">
          		<td>{{$project->id}}</td>
          		<td>{{$project->work_order}}</td>
          		<td><a href="/projects/{{$project->id}}">{{$project->name}}</a></td>
          		<td style="text-align: center;">
          			<div class="badge badge-pill " style="display: flex; justify-content: center; background-color: {{$pillColor}}; color: black; padding: 5px;">
          				{{$statusName}}
          			</div>
          		</td>
          		<td>{{$project->account_name}}</td>
          		<td>{{$project->account_number}}</td>
          		<td>{{date_format(date_create($project->due_date), "m/d/Y")}}</td>
          	</tr>

          	@endforeach
          	
          </tbody>
          <tfoot>
            <tr>
            	<th class="th-sm">Project ID</th>
            	<th class="th-sm">Work Order</th>
	            <th class="th-sm">Project Name</th>
	            <th class="th-sm">Status</th>
	            <th class="th-sm">Account</th>
	            <th class="th-sm">Account Number</th>
	            <th class="th-sm">Due Date</th>
            </tr>
          </tfoot>
		</table>
	</div>


	<style>
		.main-split-notes-view {
			display: grid;
			margin: 15px;
			grid-gap: 8px;
			grid-template-columns: 1fr 1fr;
		}
			.split-notes-table {
				grid-column: 1;
				grid-row: 1;
			}

			.split-notes-notes {
				grid-column: 2;
				grid-row: 1;
				max-height: 625px;
			}

	</style>


	<div style="display: none" id="view-notes">
		
		<div class="main-split-notes-view">
			<div class="card fragment split-notes-table">
				<table class="table table-hover table-bordered table-sm" cellspacing="0" width=100%" id="projectsTableNotes">
		          <thead >
		            <tr>
		            	<th class="th-sm">Project ID</th>
			            <th class="th-sm" id="project-name-header-notes">Project Name</th>
			            <th class="th-sm" id="status-header-notes">Status</th>
			            <th class="th-sm">Account</th>
			            <th class="th-sm">Due Date</th>
		            </tr>

		            {{csrf_field()}}
		          </thead>  
		          <tbody>
		          	@foreach($projects as $project)

		          	<?php 
		          		$statusName = $project->status;
		          		$pillColor = \App\StatusCode::where('name', $statusName)->first()->hex_color;
		          		$datetime1 = new DateTime($project->due_date);
						$datetime2 = new DateTime(today());
						$isOverDue = ($datetime1 <= $datetime2 && $statusName != 'Completed');
		          	?>

		          	<tr style="{{$isOverDue ? 'background-color: #f29d9d' : ''}}" onclick="retrieveNotes({{$project->id}}, '{{$project->name}}')">
		          		<td>{{$project->id}}</td>
		          		<td><a href="/projects/{{$project->id}}">{{$project->name}}</a></td>
		          		<td style="text-align: center;">
		          			<div class="badge badge-pill " style="display: flex; justify-content: center; background-color: {{$pillColor}}; color: black; padding: 5px;">
		          				{{$statusName}}
		          			</div>
		          		</td>
		          		<td>{{$project->account_name}}</td>
		          		<td>{{date_format(date_create($project->due_date), "m/d/Y")}}</td>
		          	</tr>

		          	@endforeach
		          	
		          </tbody>
				</table>
			</div>

			<div id="fragment-split-notes" class="card fragment split-notes-notes">
				<header>
					<font id="title-notes" size="5">Notes</font>
					<button class="btn btn-success"><i class="fa fa-plus mr-2"></i>Add Note</button>
				</header>

				<div id="section-notes" style="overflow-y: auto; max-height: 500px;">
					
				</div>
			</div>			
		</div>
	</div>


{{-- Modal New Project --}}
<div class="modal fade" id="createProjectModal" role="modal">
	<div class="modal-dialog modal-lg" >

		{{-- Modal Content --}}
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Create New Project</h4>
			</div>

			<div class="modal-body">
				<div class="create-modal-grid-container">
					<div class="grid-item create-modal-item1">
						<label for="input-project-name">Project Name</label>
						<input type="text" id="input-project-name" class="form-control" maxlength="25">
						<label for="input-account-name">Account Name</label>
						<input type="text" id="input-account-name" class="form-control" maxlength="25">
						<label for="input-account-number">Account Number</label>
						<input type="text" id="input-account-number" class="form-control" maxlength="6">

					</div>
					<div class="grid-item create-modal-item2">
						<label for="input-project-status">Project Status</label>
						<select class="form-control" id="input-project-status">
							@foreach($status_codes as $code)
                    			<option>{{$code->name}}</option>
                    		@endforeach
                  		</select>
						<label for="input-workorder">Work Order</label>
						<input type="text" id="input-workorder" class="form-control" maxlength="6">
						<label for="input-due-date">Due Date</label>
						<input type="date" id="input-due-date" class="form-control">
					</div>

					<div class="grid-item create-modal-item3">
						<label for="input-description">Description</label>
						<textarea id="input-description" class="textarea" rows="3" style="width: 100%"></textarea>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button id="btn-save-project" class="btn btn-md btn-outline-success"><i></i>Save</button>
				<button id="btn-cancel" data-dismiss="modal" class="btn btn-md btn-outline-warning"><i></i>Cancel</button>
			</div>
		</div>
		
	</div>
</div>


@endsection



@section('javascript')

	{{-- Create New Project --}}
	<script>
		$(document).ready(function() {
			$('#btn-create-project').click(function(event) {
				$('#createProjectModal').modal();
			});

			$('#btn-save-project').on('click', function(event) {
				var projectName = $('#input-project-name').val();
				var accountName = $('#input-account-name').val();
				var accountNumber = $('#input-account-number').val();
				var projectDescription = $('#input-description').val();
				var projectStatus = $('#input-project-status').val();
				var workOrder = $('#input-workorder').val();
				var projectDueDate = $('#input-due-date').val();

				// TODO add var validation function
				$.ajax({
					type: 'POST',
					url: '/projects',
					data: {
						'_token' : $('input[name=_token]').val(),
						'name' : projectName,
						'account_name' : accountName,
						'account_number' : accountNumber,
						'description' : projectDescription,
						'status' : projectStatus,
						'work_order' : workOrder,
						'due_date' : projectDueDate
						
					},
					error: function(data) {
						console.log('app: ' + data.responseText);
						var jsonString = '';
						$.each(JSON.parse(data.responseText), function(key, value) {
							console.log('value: ' + value);
							jsonString += value;
						});

						toastr.error(jsonString, 'Error', {timeOut: 5000});
					},
					success: function(data) {
						toastr.success(projectName + ' successfully saved to DB', 'Success', {timeOut: 5000});

						$('#createProjectModal').modal('toggle');
					}
				});
			});

			$('#btn-all-projects').on('click', function(event) {
				$('#cardview-all-projects').css('display', "");
				$('#view-notes').css('display', "none");

			});

			$('#btn-project-notes').on('click', function(event) {
				$('#cardview-all-projects').css('display', "none");
				$('#view-notes').css('display', "");
				$('#project-name-header-notes').click(); //hacky way to solve detached header issue, but it does sort too
			});
		});
	</script>

    {{-- Format Table --}}
    <script>
      $(document).ready(function () {
        $('#projectsTable').DataTable({
          "scrollY": "300px",
          "scrollCollapse": true
        });
        $('.dataTables_length').addClass('bs-select');
      });
    </script>


        {{-- Format Notes Table --}}
    <script>
      $(document).ready(function () {
        $('#projectsTableNotes').DataTable({
          "scrollY": "300px",
          // "scrollCollapse": true
        });
        $('.dataTables_length').addClass('bs-select');
      });
    </script>



@endsection