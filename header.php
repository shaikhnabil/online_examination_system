<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Online Examination System</title>

	<!-- Custom styles for this page -->
	<link href="vendor/bootstrap/bootstrap.min.css" rel="stylesheet">

	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="../vendor/parsley/parsley.css"/>
	<!-- Custom styles for this page -->
	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="vendor/parsley/parsley.css" />
	<link rel="stylesheet" type="text/css" href="vendor/TimeCircle/TimeCircles.css" />

	<style>
		body{
			background-color: #f3e9ff;
		}
		.border-top {
			border-top: 1px solid #e5e5e5;
		}

		.border-bottom {
			border-bottom: 1px solid #e5e5e5;
		}

		.box-shadow {
			box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05);
		}

		/* navbar style */
		
		.navbar-nav li a:hover,
    .navbar-nav li.active a {
      color: #8548d2 !important;
      background-color: #fff !important;
    }
	</style>

	<script>
		
			
	</script>

	
</head>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
	<?php
	//check student is login
	if ($object->is_student_login()) {
	?>
		<!-- navbar -->
		<!-- <nav class="navbar navbar-expand-lg">
			<a class="navbar-brand" href="#">ONLINE EXAM</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarText">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="student_dashboard.php">Home</a>
					</li>
					<li class="nav-item ">
						<a class="nav-link" href="exam.php">Exam</a>
					</li>
					<li class="nav-item ">
						<a class="nav-link" href="logout.php">Logout</a>
					</li>
				</ul>
			</div>
		</nav> -->

		<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
			<a class="navbar-brand" href="#">ONLINE EXAM</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="student_dashboard.php">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="exam.php">Exam</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="change_password.php">Change Password</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="logout.php">Logout</a>
					</li>
				</ul>
			</div>
		</nav>
		

	<?php
	} else {
	?>
		<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-0 bg-white border-bottom box-shadow">
			<h5 class="my-0 mr-md-auto font-weight-normal">ONLINE EXAM</h5>

		</div>

		<!-- <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
	      	<h1 class="display-4">ONLINE EXAMINATION SYSTEM</h1>
	    </div> -->
		<br />
		<br />
	<?php
	}
	?>
	<div class="container-fluid">