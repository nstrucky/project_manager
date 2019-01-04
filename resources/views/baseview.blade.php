<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>

	<!-- Font Awesome -->
  	{{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
  	<!-- Bootstrap core CSS -->
  	<link href="css/bootstrap.min.css" rel="stylesheet">
  	<!-- Material Design Bootstrap -->
  	<link href="css/mdb.min.css" rel="stylesheet">
  	<!-- Your custom styles (optional) -->
 	<link href="css/style.min.css" rel="stylesheet">
  	<!-- MDBootstrap Datatables  -->
  	<link href="css/addons/datatables.min.css" rel="stylesheet">
  	<!-- toastr notifications -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<!-- Add icon library -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <meta name="_token" content="{{csrf_token()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<style>
		.pm-header {
			padding: 10px;
			background-color: #ccdfff;
		}

		.top-nav {
			float: top;
			width: auto;
			height: 100px;
			background-color: #ccdfff;
			padding: 10px;

		}

		.left-nav {
			float: left;
			width: 200px;
			height: 1000px;
			background-color: #ffe0e0;
			padding: 10px;
		}

		.left-nav-btn-group {
			margin-top: 25px;
		}

		.btn.navbar-item {
			/*float: right;*/
			/*width: 100%;*/

		}

		.header-title {
			margin-bottom: 10px;
			color: #707070;
		}


	</style>


	<nav class="top-nav pm-header">
		<h1 class="header-title">Project Manager</h1>
		<div class="btn-group btn-group-lg">
			<form action="/projects" method="GET"><button id="projects-nav-btn" class="btn btn-lg @yield('button-projects-type') navbar-item">Projects</button></form>
			<form action="/tasks" method="GET"><button id="tasks-nav-btn" class="btn btn-lg @yield('button-tasks-type') navbar-item">Tasks</button></form>
			<form action="/users" method="GET"><button id="users-nav-btn" class="btn btn-lg @yield('button-users-type') navbar-item">Users</button></form>
			<form action="/settings" method="GET"><button id="settings-nav-btn" class="btn btn-lg @yield('button-settings-type') navbar-item">Settings</button></form>			
		</div>
	</nav>


	<nav class="left-nav">
		@yield('left-nav')
	</nav>


	@yield('content')

	{{-- JAVASCRIPT ******************************************************************************************************************--}}
   	<!-- JQuery -->
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="js/mdb.min.js"></script>
    <!-- MDBootstrap Datatables  -->
    <script type="text/javascript" src="js/addons/datatables.min.js"></script>
        <!-- toastr notifications -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    @yield('javascript')

</body>
</html>