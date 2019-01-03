<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>

	<!-- Font Awesome -->
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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

    <meta name="_token" content="{{csrf_token()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<style>
		.top-nav {
			float: top;
			width: auto;
			height: 150px;
			background-color: #cccccc;
			padding: 10px;
		}

		.left-nav {
			float: left;
			width: 200px;
			height: 1000px;
			background-color: #cccccc;
			padding: 10px;
		}

		.btn.navbar-item {
			float: right;
			width: 100%;

		}
	</style>

	<nav class="top-nav">
		
	</nav>
	<nav class="left-nav">
		<button id="projects-nav-btn" class="btn btn-md btn-primary navbar-item">Projects</button>
		<button id="tasks-nav-btn" class="btn btn-md btn-primary navbar-item">Tasks</button>
		<button id="users-nav-btn" class="btn btn-md btn-primary navbar-item">Users</button>
		<button id="settings-nav-btn" class="btn btn-md btn-primary navbar-item">Settings</button>
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