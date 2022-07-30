<?php

//contact_action.php
//add class file
include('admin/online_exam.php');
//create object
$object = new online_exam();
//add contact details in contact table
if(isset($_POST["action"]))
{
    if($_POST["action"] == 'Add')
	{
		$error = '';

		$success = '';

		// $data = array(
		// 	':email'	=>	$_POST["email"]
		// );

		// $object->execute($data);


			$data = array(
				':name'			=>	$object->clean_input($_POST["name"]),
				':email'		=>	$object->clean_input($_POST["email"]),
				':subject'		=>	$_POST["subject"],
				':message'		=>	$_POST["message"],
				':contact_on'		=>	$object->now
			);

			$object->query = "
			INSERT INTO contact 
			(name, email, subject, message, contact_on) 
			VALUES (:name, :email, :subject, :message, :contact_on)
			";

			$object->execute($data);

			$success = '<div class="alert alert-success">Data Submitted</div>';
		

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}
}