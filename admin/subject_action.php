<?php

//subject_action.php
//add class file
include('online_exam.php');
//create object
$object = new online_exam();

if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$order_column = array('exam_class.class_name','subject_to_class.subject_code' ,'subject_to_class.subject_name', 'subject_to_class.added_on');

		$output = array();

		$main_query = "
		SELECT * FROM subject_to_class
		INNER JOIN exam_class
		ON exam_class.class_id = subject_to_class.class_id 
		";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE subject_to_class.subject_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR exam_class.class_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR subject_status LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY subject_to_class.subject_to_class_id DESC ';
		}

		$limit_query = '';

		if($_POST["length"] != -1)
		{
			$limit_query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$object->query = $main_query . $search_query . $order_query;

		$object->execute();

		$filtered_rows = $object->row_count();

		$object->query .= $limit_query;

		$result = $object->get_result();

		$object->query = $main_query;

		$object->execute();

		$total_rows = $object->row_count();

		$data = array();

		foreach($result as $row)
		{
			$sub_array = array();
			$sub_array[] = html_entity_decode($row["class_name"]);
			$sub_array[] = html_entity_decode($row["subject_code"]);
			$sub_array[] = html_entity_decode($row["subject_name"]);
			$sub_array[] = $row["added_on"];
			$status = '';
			if($row["subject_status"] == 'Enable')
			{
				$status = '<button type="button" name="status_button" class="btn btn-primary btn-sm status_button" data-id="'.$row["subject_to_class_id"].'" data-status="'.$row["subject_status"].'">Enable</button>';
			}
			else
			{
				$status = '<button type="button" name="status_button" class="btn btn-danger btn-sm status_button" data-id="'.$row["subject_to_class_id"].'" data-status="'.$row["subject_status"].'">Disable</button>';
			}
			$sub_array[] = $status;
			$sub_array[] = '
			<div align="center">
			<button type="button" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" data-id="'.$row["subject_to_class_id"].'"><i class="fas fa-edit"></i></button>
			&nbsp;
			<button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$row["subject_to_class_id"].'"><i class="fas fa-trash-alt"></i></button>
			</div>
			';
			$data[] = $sub_array;
		}

		$output = array(
			"draw"    			=> 	intval($_POST["draw"]),
			"recordsTotal"  	=>  $total_rows,
			"recordsFiltered" 	=> 	$filtered_rows,
			"data"    			=> 	$data
		);
			
		echo json_encode($output);
	}

//add subject
if($_POST["action"] == 'Add')
{
	$error = '';

	$success = '';

	$data = array(
		':class_id'		=>	$_POST["class_id"],
		':subject_code'	=>	$_POST["subject_code"]
	);

	$object->query = "
	SELECT * FROM subject_to_class 
	WHERE class_id = :class_id 
	AND subject_code = :subject_code
	";

	$object->execute($data);

	if($object->row_count() > 0)
	{
		$error = '<div class="alert alert-danger">Subject Name or subject code Already Exist in same class</div>';
	}
	else
	{
		$data = array(
			':class_id'				=>	$_POST["class_id"],
			':subject_code'			=>	$_POST["subject_code"],
			':subject_name'			=>	$object->clean_input($_POST["subject_name"]),
			':subject_status'		=>	'Enable',
			':added_on'				=>	$object->now
		);

		$object->query = "
		INSERT INTO subject_to_class 
		(class_id, subject_code, subject_name, subject_status, added_on) 
		VALUES (:class_id, :subject_code, :subject_name, :subject_status, :added_on)
		";

		$object->execute($data);

		$success = '<div class="alert alert-success">Subject Added to <b>'.$object->Get_class_name($_POST["class_id"]).'</b> class</div>';
	}

	$output = array(
		'error'		=>	$error,
		'success'	=>	$success
	);

	echo json_encode($output);

}
//fetch single data
if($_POST["action"] == 'fetch_single')
{
	$object->query = "
	SELECT * FROM subject_to_class 
	WHERE subject_to_class_id = '".$_POST["subject_to_class_id"]."'
	";

	$result = $object->get_result();

	$data = array();

	foreach($result as $row)
	{
		$data['class_id'] = $row['class_id'];
		$data['subject_code'] = $row['subject_code'];
		$data['subject_name'] = html_entity_decode($row['subject_name']);
	}

	echo json_encode($data);
}
//edit subject
if($_POST["action"] == 'Edit')
	{
		$error = '';

		$success = '';

		$data = array(
			':class_id'			=>	$_POST["class_id"],
			':subject_code'		=>	$_POST["subject_code"],
			':subject_name'	=>	$_POST["subject_name"]
		);

		$object->query = "
		SELECT * FROM subject_to_class 
		WHERE class_id = :class_id 
		AND subject_code = :subject_code
		AND subject_name = :subject_name";

		$object->execute($data);

		if($object->row_count() > 0)
		{
		$error = '<div class="alert alert-danger">Subject Name or subject code Already Exist in same class</div>';
		}
		else
		{

			$object->query = "
			UPDATE subject_to_class
			SET class_id = :class_id, subject_code = :subject_code, subject_name = :subject_name 
			WHERE subject_to_class_id = '".$_POST['hidden_id']."'
			";;

			$object->execute($data);

			$success = '<div class="alert alert-success">Subject Data Updated</div>';
		}

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}
	//change status of subject

	if($_POST["action"] == 'change_status')
	{
		$data = array(
			':subject_status'		=>	$_POST['next_status']
		);

		$object->query = "
		UPDATE subject_to_class 
		SET subject_status = :subject_status 
		WHERE subject_to_class_id = '".$_POST["id"]."'
		";

		$object->execute($data);

		echo '<div class="alert alert-success">Subject Status change to '.$_POST['next_status'].'</div>';
	}
	//delete subject
	if($_POST["action"] == 'delete')
	{
		$object->query = "
		DELETE FROM subject_to_class
		WHERE subject_to_class_id = '".$_POST["id"]."'
		";

		$object->execute();

		echo '<div class="alert alert-success">Subject Data Deleted</div>';
	}

}
