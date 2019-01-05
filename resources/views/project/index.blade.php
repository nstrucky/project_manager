@extends('baseview')

@section('title', 'Projects')

@section('button-projects-type', "btn-dark")
@section('button-tasks-type', "btn-primary")
@section('button-users-type', "btn-primary")
@section('button-settings-type', "btn-primary")

@section('left-nav')

	<div role="group" class="btn-group-vertical">
		<button id="btn-create-project" type="button" class="btn btn-md btn-outline-default"><i class="fa fa-plus-circle mr-2"></i>New Project</button>
		<button id="btn-all-projects" type="button" class="btn btn-md btn-outline-primary"><i class="fa fa-table mr-2"></i>All Projects</button>
		<button id="btn-project-notes" type="button" class="btn btn-md btn-outline-primary"><i class="fa fa-pencil-square-o mr-2"></i>Notes</button>
	</div>

@endsection

@section('content')

	<style>
		
		      table.dataTable thead .sorting:after,
      table.dataTable thead .sorting:before,
      table.dataTable thead .sorting_asc:after,
      table.dataTable thead .sorting_asc:before,
      table.dataTable thead .sorting_asc_disabled:after,
      table.dataTable thead .sorting_asc_disabled:before,
      table.dataTable thead .sorting_desc:after,
      table.dataTable thead .sorting_desc:before,
      table.dataTable thead .sorting_desc_disabled:after,
      table.dataTable thead .sorting_desc_disabled:before {
         bottom: .5em;
      }

		.modal-header {
			background-color: #164899;
		}

		.modal-title {
			color: #e2e2e2;
		}

		.modal-footer {
			background-color: #303030;
		}

		.table-view {
			padding: 25px;
			margin: 25px;
		}
	</style>



	<div class="card table-view" id="table-all-projects">
		<table class="table table-bordered table-sm" cellspacing="0" width="100%" id="projectsTable">
          <thead >
           <tr>
              <td></td>
              <td></td>
              <td>
                <div>
                  <select class="form-control-sm" id="status_select" style="width: 100%" onchange="filterBySelect('status_select', 'projectsTable', 2)">
                    <option>All</option>
                    <option>Not Started</option>
                    <option>In Progress</option>
                    <option>Complete</option>
                  </select>
                </div>
              </td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <th valign="middle">ID</th>
              <th class="th-sm">Title</th>
              <th class="th-sm">Status</th>
              <th class="th-sm">Contents</th>
              <th class="th-sm">Published</th>
              <th class="th-sm">Last Updated</th>
            </tr>

            {{csrf_field()}}
          </thead>  
          <tbody>
          	
          </tbody>
          <tfoot>
            <tr>
              <th valign="middle">ID</th>
              <th class="th-sm">Title</th>
              <th class="th-sm">Status</th>
              <th class="th-sm">Contents</th>
              <th class="th-sm">Published</th>
              <th class="th-sm">Last Updated</th>
            </tr>
          </tfoot>
		</table>
	</div>


	<div style="color: white; display: none" id="view-notes">
		Test notes
	</div>


	<style>
		.grid-container {
			display: -ms-grid;
			display: grid;
			margin: 15px;
			grid-gap: 10px;
			-ms-grid-columns:2fr 1fr;
		}

		.grid-item {
			padding: 10px;
		}

		.item1 {
			grid-column: 1;
			grid-row: 1;
			-ms-grid-column: 1;
			-ms-grid-row: 1;
		}

		.item2 {
			grid-column: 2;
			grid-row: 1;
			-ms-grid-column: 2;
			-ms-grid-row: 1;
		}

		.item3 {
			grid-column: 1 / span 2;
			grid-row: 2;
			-ms-grid-column: 1;
			-ms-grid-column-span: 2;
			-ms-grid-row: 2;
		}
	</style>


{{-- Modal New Project --}}
<div class="modal fade" id="createProjectModal" role="modal">
	<div class="modal-dialog modal-lg" >

		{{-- Modal Content --}}
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Create New Project</h4>
			</div>

			<div class="modal-body">
				<div class="grid-container">
					<div class="grid-item item1">
						<label for="input-project-name">Project Name</label>
						<input type="text" id="input-project-name" class="form-control">
						<label for="input-account-name">Account Name</label>
						<input type="text" id="input-account-name" class="form-control">
						<label for="input-account-number">Account Number</label>
						<input type="text" id="input-account-number" class="form-control">

					</div>
					<div class="grid-item item2">
						<label for="input-project-status">Project Status</label>
						<select class="form-control" id="input-project-status">
		                    <option value="0">Not Started</option>
		                    <option value="1">In Progress</option>
		                    <option value="2">Complete</option>
                  		</select>
						<label for="input-workorder">Work Order</label>
						<input type="text" id="input-workorder" class="form-control">
						<label for="input-due-date">Due Date</label>
						<input type="date" id="input-due-date" class="form-control">
					</div>

					<div class="grid-item item3">
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
						'work_orders' : workOrder,
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
				$('#table-all-projects').css('display', "");
				$('#view-notes').css('display', "none");

			});

			$('#btn-project-notes').on('click', function(event) {
				$('#table-all-projects').css('display', "none");
				$('#view-notes').css('display', "");
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

@endsection