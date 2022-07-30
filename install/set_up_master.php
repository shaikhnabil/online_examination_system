
<?php



$message = '';

$connect = '';

$base_url = '';

error_reporting(0);

if(file_exists('db_info.inc'))//check db_info file is available
{
	include('db_info.inc'); //add db_info file
	try //try to connect to database
	{
		$connect = new PDO("mysql:host=$edb_host;dbname=$edb_name", $edb_user_name, $edb_password);
		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION, PDO::ERRMODE_WARNING);

		$query = "SELECT * FROM user_register 
		WHERE user_type = 'Admin' 
		AND user_status = 'Enable'
		";
		$statement = $connect->prepare($query);
		$statement->execute();
		if($statement->rowCount() > 0)
		{
			header('location:'.$ebase_url.'admin/index.php');
		}
		else //if admin not available then move to admin register page
		{
			$message = 'Set Up Master Account';
			$base_url = $ebase_url;
		}
	}
	catch(PDOException $e)
	{
		header('location:'.$ebase_url.'admin/index.php');
	}
}
else
{
	header('location:'.$ebase_url.'admin/index.php');
}

function make_avatar($character)
{
    $path = "../images/". time() . ".png";
	$image = imagecreate(200, 200);
	$red = rand(0, 255);
	$green = rand(0, 255);
	$blue = rand(0, 255);
    imagecolorallocate($image, 230, 230, 230);  
    $textcolor = imagecolorallocate($image, $red, $green, $blue);
    imagettftext($image, 100, 0, 55, 150, $textcolor, '../font/arial.ttf', $character);
    imagepng($image, $path);
    imagedestroy($image);
    return $path;
}

if(isset($_POST["submit"])) //if form request is submit then make array of data and perform insert query to register admin
{
	include('db_info.inc');

	$connect = new PDO("mysql:host=$edb_host;dbname=$edb_name", $edb_user_name, $edb_password);

	$user_image = make_avatar(strtoupper($_POST["user_name"][0]));

	$data = array(
		':user_name'	=>	trim($_POST["user_name"]),
		':user_contact_no'=> '',
		':user_email'	=>	trim($_POST["user_email"]),
		':user_password'=>	trim($_POST["user_password"]),
		':user_profile'	=>	$user_image,
		':user_qualification'=> '',
		':user_type'	=>	'Admin',
		':user_status'	=>	'Enable',
		':user_created_on'	=>	date('Y-m-d H:i:s'),
		':user_verification_code'=> ''
	);

	$query = "INSERT INTO user_register (user_name, user_contact_no, user_email, user_password, user_profile, user_qualification, user_type, user_status, user_created_on, user_verification_code) 
	VALUES (:user_name, :user_contact_no, :user_email, :user_password, :user_profile, :user_qualification, :user_type, :user_status, :user_created_on, :user_verification_code)
	";

	$statement = $connect->prepare($query);
	$statement->execute($data);
	header('location:'.$base_url.'admin/index.php');
}

?>

<!-- admin register form  -->
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Online Examination Admin registration</title>

	    <!-- Custom styles for this page -->
	    <link href="../vendor/bootstrap/bootstrap.min.css" rel="stylesheet">

	    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

	    <!-- Custom styles for this page -->
    	<link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

	    <link rel="stylesheet" type="text/css" href="../vendor/parsley/parsley.css"/>
	    <link rel="stylesheet" type="text/css" href="../vendor/TimeCircle/TimeCircles.css"/>
	    <style>
	    	.border-top { border-top: 1px solid #e5e5e5; }
			.border-bottom { border-bottom: 1px solid #e5e5e5; }

			.box-shadow { box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05); }
	    </style>
	</head>
	<body>
		<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
		    <h5 class="my-0 mr-md-auto font-weight-normal">Online Exam</h5>
		    
	    </div>

	    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
	      	<h1 class="display-4">Online Examination System</h1>
	    </div>
	    <div class="container-fluid">
		    <div class="container">
			    <div class="card mt-4 mb-4">
			      	<div class="card-header"><b><?php echo $message; ?></b></div>
			      	<div class="cart-body col-sm-12">
			      		<form method="post" class="mt-4 mb-4" id="set_up_master_form">
			      			<div class="form-group row">
						    	<label for="user_name" class="col-sm-2 col-form-label"><b>Master User Name</b></label>
						    	<div class="col-sm-4">
						      		<input type="text" name="user_name" class="form-control" id="user_name" required data-parsley-trigger="keyup">
						    	</div>
						    	<div class="col-sm-6 text-muted">Enter Master User Name Details</div>
						  	</div>
						  	<div class="form-group row">
						    	<label for="user_email" class="col-sm-2 col-form-label"><b>Email Address</b></label>
						    	<div class="col-sm-4">
						      		<input type="email" name="user_email" class="form-control" id="user_email" required data-parsley-trigger="keyup">
						    	</div>
						    	<div class="col-sm-6 text-muted">Enter Master User Email Address</div>
						  	</div>
						  	<div class="form-group row">
						    	<label for="user_password" class="col-sm-2 col-form-label"><b>Password</b></label>
						    	<div class="col-sm-4">
						      		<input type="password" name="user_password" class="form-control" id="user_password" required data-parsley-trigger="keyup">
						    	</div>
						    	<div class="col-sm-6 text-muted">Enter Master User Login Password</div>
						  	</div>
						  	<div class="form-group mt-5">
						  		<input type="submit" name="submit" id="submit_button" class="btn btn-primary" value="submit" />
						  	</div>
			      		</form>
			      	</div>
			    </div>
			</div>
		</div>
		<!-- Bootstrap core JavaScript-->
	    <script src="../vendor/jquery/jquery.min.js"></script>
	    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    	<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

	    <!-- Core plugin JavaScript-->
	    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

	    <script type="text/javascript" src="../vendor/parsley/dist/parsley.min.js"></script>

	    <script type="text/javascript" src="../vendor/TimeCircle/TimeCircles.js"></script>

	</body>
</html>

<script>

$(document).ready(function(){

	$('#set_up_master_form').parsley();

	if($('#set_up_master_form').parsley().isValid())
	{
		$('#submit_button').attr('disabled', disabled);
		$('#submit_button').val('Wait...');
		return true;
	}
	else
	{
		return false;
	}

});

</script>