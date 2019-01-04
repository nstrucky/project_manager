@extends('baseview')

@section('title', 'Projects')

@section('button-projects-type', "btn-dark")
@section('button-tasks-type', "btn-primary")
@section('button-users-type', "btn-primary")
@section('button-settings-type', "btn-primary")

@section('left-nav')

	<div role="group" class="button-group left-nav-btn-group">
		<button id="btn-create-project" type="button" class="btn btn-md btn-outline-default"><i class="fa fa-plus-circle mr-2"></i>New Project</button>
		<button type="button" class="btn btn-md btn-outline-primary"><i class="fa fa-table mr-2"></i>All Projects</button>
		<button type="button" class="btn btn-md btn-outline-primary"><i class="fa fa-pencil-square-o mr-2"></i>Latest Notes</button>
	</div>

@endsection

@section('content')

	<style>
		
		.modal-header {
			background-color: #164899;
		}

		.modal-title {
			color: #e2e2e2;
		}

		.modal-footer {
			background-color: #303030;
		}
	</style>

<div class="modal fade" id="createProjectModal" role="modal">
	<div class="modal-dialog" >

		{{-- Modal Content --}}
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Create New Project</h4>
			</div>

			<div class="modal-body">
				
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
				toastr.success('Button Worked', 'Success', {timeOut: 5000});
			});
		});
	</script>


@endsection