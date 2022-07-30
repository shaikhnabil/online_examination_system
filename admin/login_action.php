<?php

//login_action.php
//include class file
include('online_exam.php');
//create object
$object = new online_exam();
//check email post request
if (isset($_POST["user_email"])) {
	sleep(2);
	$error = '';
	$url = '';
	$data = array(
		':user_email'	=>	$_POST["user_email"]
	); //create array of user email

	$object->query = "SELECT * FROM user_register 
		WHERE user_email = :user_email"; //query to check email is register

	$object->execute($data); //execute data

	$total_row = $object->row_count();
	//if email id is not register than row_count() return 0
	if ($total_row == 0) {

		$error = '<div class="alert alert-danger">Sorry, Wrong Email Address</div>';
	} else {
		//$result = $statement->fetchAll();

		$result = $object->statement_result();

		foreach ($result as $row) {
			if ($row["user_status"] == 'Enable') {
				if ($_POST["user_password"] == $row["user_password"]) //check password is equal to register password
				{
					$_SESSION['user_id'] = $row['user_id']; //set session
					$_SESSION['user_type'] = $row['user_type'];
					if ($row['user_type'] == 'Admin') { //if user = Admin send to admin dashboard page
						$url = $object->base_url . 'admin/dashboard.php';
					} 
					elseif($row['user_type'] == 'Teacher') { //if user = teacher send to teacher page
						$url = $object->base_url . 'admin/dashboard.php';
					}
					else {
						$url = $object->base_url . 'admin/result.php';
					}
				} else {
					$error ='<div class="alert alert-danger">Sorry, Wrong password</div>';
				}
			} else {
				$error = '<div class="alert alert-danger">Sorry, Your account has been disable, contact Admin</div>';
			}
		}
	}

	$output = array(
		'error'		=>	$error,
		'url'		=>	$url
	);

	echo json_encode($output);
}
