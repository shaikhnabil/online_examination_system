<?php

//assign_student_action.php
//add class file
include('online_exam.php');
//create object
$object = new online_exam();
//if is action  = fetch then send data to datatables
if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$order_column = array('student_to_class.student_roll_no', 'student_register.student_name', 'exam_class.class_name', 'student_to_class.added_on');

		$output = array();

		$main_query = "
		SELECT * FROM student_to_class 
		INNER JOIN exam_class 
		ON exam_class.class_id = student_to_class.class_id 
		INNER JOIN student_register 
		ON student_register.student_id = student_to_class.student_id 
		";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE exam_class.class_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR student_register.student_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR student_to_class.student_roll_no LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY student_to_class.student_to_class_id DESC ';
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
			$sub_array[] = $row["student_roll_no"];
			$sub_array[] = html_entity_decode($row["student_name"]);
			$sub_array[] = html_entity_decode($row["class_name"]);
			$sub_array[] = $row["added_on"];
			$sub_array[] = '
			<div align="center">
			<button type="button" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" data-id="'.$row["student_to_class_id"].'"><i class="fas fa-edit"></i></button>
			&nbsp;
			<button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$row["student_to_class_id"].'"><i class="fas fa-trash"></i></button>
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
//asssign student to specific class
	if($_POST["action"] == 'Add')
	{
		$error = '';

		$success = '';

		$data = array(
			':class_id'			=>	$_POST["class_id"],
			':student_id'		=>	$_POST["student_id"],
			':student_roll_no'	=>	$_POST["student_roll_no"]
		);

		$object->query = "
		SELECT * FROM student_to_class 
		WHERE class_id = :class_id 
		AND student_id = :student_id 
		AND student_roll_no = :student_roll_no
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Duplicate Data</div>';
		}
		else
		{
			$data = array(
				':class_id'				=>	$_POST["class_id"],
				':student_id'			=>	$_POST["student_id"],
				':student_roll_no'		=>	$_POST["student_roll_no"],
				':added_on'				=>	$object->now
			);

			$object->query = "
			INSERT INTO student_to_class 
			(class_id, student_id, student_roll_no, added_on) 
			VALUES (:class_id, :student_id, :student_roll_no, :added_on)
			";

			$object->execute($data);

			$success = '<div class="alert alert-success">Student Assign to <b>'.$object->Get_class_name($_POST["class_id"]).'</b> class</div>';
		}

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}
//fetch single data from student_to_class table
	if($_POST["action"] == 'fetch_single')
	{
		$object->query = "
		SELECT * FROM student_to_class 
		WHERE student_to_class_id = '".$_POST["student_to_class_id"]."'
		";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			$data['class_id'] = $row['class_id'];
			$data['student_id'] = $row['student_id'];
			$data['student_roll_no'] = $row['student_roll_no'];
		}

		echo json_encode($data);
	}
//Edit student_to_class table data
	if($_POST["action"] == 'Edit')
	{
		$error = '';

		$success = '';

		$data = array(
			':class_id'			=>	$_POST["class_id"],
			':student_id'		=>	$_POST["student_id"],
			':student_roll_no'	=>	$_POST["student_roll_no"]
		);

		$object->query = "
		SELECT * FROM student_to_class
		WHERE class_id = :class_id 
		AND student_id = :student_id 
		AND student_roll_no = :student_roll_no 
		AND student_to_class_id != '".$_POST['hidden_id']."'
		";

		$object->execute($data);

		if($object->row_count() > 0)
		{
			$error = '<div class="alert alert-danger">Duplicate Data</div>';
		}
		else
		{

			$object->query = "
			UPDATE student_to_class 
			SET class_id = :class_id, student_id = :student_id, student_roll_no = :student_roll_no  
			WHERE student_to_class_id = '".$_POST['hidden_id']."'
			";

			$object->execute($data);

			$success = '<div class="alert alert-success">Student Data Updated</div>';
		}

		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}
//delete data of student based on id
	if($_POST["action"] == 'delete')
	{
		$object->query = "
		DELETE FROM student_to_class
		WHERE student_to_class_id = '".$_POST["id"]."'
		";

		$object->execute();

		echo '<div class="alert alert-success">Student Data Deleted</div>';
	}

}



?>