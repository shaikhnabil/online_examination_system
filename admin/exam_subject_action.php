<?php

//exam_subject_action.php
//add class file
include('online_exam.php');
//create object
$object = new online_exam();
//fetch data
if(isset($_POST["action"]))
{
	if($_POST["action"] == 'fetch')
	{
		$order_column = array('exam.exam_title', 'subject_to_class.subject_name', 'subject_wise_exam.subject_exam_datetime', 'subject_wise_exam.subject_total_question', 'subject_wise_exam.marks_per_right_answer', 'subject_wise_exam.marks_per_wrong_answer');

		$output = array();

		$main_query = "
		SELECT * FROM subject_wise_exam
		INNER JOIN exam
		ON exam.exam_id = subject_wise_exam.exam_id 
		INNER JOIN subject_to_class 
		ON subject_to_class.subject_to_class_id = subject_wise_exam.subject_to_class_id
		";

		$search_query = '';

		if(isset($_POST["search"]["value"]))
		{
			$search_query .= 'WHERE exam.exam_title LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR subject_to_class.subject_name LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR subject_wise_exam.subject_exam_datetime LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR subject_wise_exam.subject_total_question LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR subject_wise_exam.marks_per_right_answer LIKE "%'.$_POST["search"]["value"].'%" ';
			$search_query .= 'OR subject_wise_exam.marks_per_wrong_answer LIKE "%'.$_POST["search"]["value"].'%" ';
		}

		if(isset($_POST["order"]))
		{
			$order_query = 'ORDER BY '.$order_column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$order_query = 'ORDER BY subject_wise_exam.exam_subject_id DESC ';
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
			$sub_array[] = html_entity_decode($row["exam_title"]);
			$sub_array[] = html_entity_decode($row["subject_name"]);
			$sub_array[] = $row["subject_exam_datetime"];
			$sub_array[] = $row["subject_total_question"] . ' Question';
			$sub_array[] = $row["marks_per_right_answer"] . ' Mark';
			$sub_array[] = '-' . $row["marks_per_wrong_answer"] . ' Mark';

			$sub_array[] = '
			<div align="center">
			<button type="button" name="edit_button" class="btn btn-warning btn-circle btn-sm edit_button" data-id="'.$row["exam_subject_id"].'"><i class="fas fa-edit"></i></button>
			
			<button type="button" name="delete_button" class="btn btn-danger btn-circle btn-sm delete_button" data-id="'.$row["exam_subject_id"].'"><i class="fas fa-trash"></i></button>
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
//fetch subject data
if($_POST['action'] == 'fetch_subject')
	{
		$object->query = "
		SELECT subject_to_class.subject_to_class_id, subject_to_class.subject_name 
		FROM exam 
		INNER JOIN subject_to_class
		ON subject_to_class.class_id = exam.exam_class_id  
		WHERE exam.exam_id = '".$_POST["exam_id"]."' 
		ORDER BY subject_to_class.subject_to_class_id ASC";

		$result = $object->get_result();
		$html = '<option value="">Select Subject</option>';
		foreach($result as $row)
		{
			if(!$object->Check_subject_already_added_in_exam($_POST["exam_id"], $row['subject_to_class_id']))
			{
				$html .= '<option value="'.$row['subject_to_class_id'].'">'.$row['subject_name'].'</option>';
			}
		}
		echo $html;
	}
//add subject to exam
	if($_POST["action"] == 'Add')
	{
		$error = '';

		$success = '';
		
		$data = array(
			':exam_id'					=>	$_POST["exam_id"],
			':subject_to_class_id'				=>	$_POST["subject_to_class_id"],
			':subject_total_question'	=>	$_POST["subject_total_question"],
			':marks_per_right_answer'	=>	$_POST["marks_per_right_answer"],
			':marks_per_wrong_answer'	=>	$_POST["marks_per_wrong_answer"],
			':subject_exam_datetime'	=>	$_POST["subject_exam_datetime"],
			':subject_exam_code'		=>	md5(uniqid())
		);

		$object->query = "
		INSERT INTO subject_wise_exam 
		(exam_id, subject_to_class_id, subject_total_question, marks_per_right_answer, marks_per_wrong_answer, subject_exam_datetime, subject_exam_code) 
		VALUES (:exam_id, :subject_to_class_id, :subject_total_question, :marks_per_right_answer, :marks_per_wrong_answer, :subject_exam_datetime, :subject_exam_code)
		";

		$object->execute($data);

		$success = '<div class="alert alert-success">Subject Added in <b>'.$object->Get_exam_name($_POST["exam_id"]).'</b> Class</div>';

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
		SELECT * FROM subject_wise_exam 
		WHERE exam_subject_id = '".$_POST["exam_subject_id"]."'
		";

		$result = $object->get_result();

		$data = array();

		foreach($result as $row)
		{
			$data['exam_id'] = $row['exam_id'];
			$data['subject_to_class_id'] = $row['subject_to_class_id'];
			$data['subject_total_question'] = $row['subject_total_question'];
			$data['marks_per_right_answer'] = $row['marks_per_right_answer'];
			$data['marks_per_wrong_answer'] = $row['marks_per_wrong_answer'];
			$data['subject_exam_datetime'] = $row['subject_exam_datetime'];
			$data['subject_select_box'] = '<option value="">Select Subject</option><option value="'.$row['subject_to_class_id'].'">'.$object->Get_Subject_name($row['subject_to_class_id']).'</option>';
		}

		echo json_encode($data);
	}
//edit data
	if($_POST["action"] == 'Edit')
	{
		$error = '';

		$success = '';

		$data = array(
			':subject_total_question'	=>	$_POST["subject_total_question"],
			':marks_per_right_answer'	=>	$_POST["marks_per_right_answer"],
			':marks_per_wrong_answer'	=>	$_POST["marks_per_wrong_answer"],
			':subject_exam_datetime'	=>	$_POST["subject_exam_datetime"]
		);

		$object->query = "
		UPDATE subject_wise_exam
		SET subject_total_question = :subject_total_question, 
		marks_per_right_answer = :marks_per_right_answer,
		marks_per_wrong_answer = :marks_per_wrong_answer, 
		subject_exam_datetime = :subject_exam_datetime    
		WHERE exam_subject_id = '".$_POST['hidden_id']."'
		";

		$object->execute($data);

		$success = '<div class="alert alert-success">Exam Subject Data Updated</div>';
		
		$output = array(
			'error'		=>	$error,
			'success'	=>	$success
		);

		echo json_encode($output);

	}
//delete exam subject data
	if($_POST["action"] == 'delete')
	{
		$object->query = "
		DELETE FROM subject_wise_exam 
		WHERE exam_subject_id = '".$_POST["id"]."'
		";

		$object->execute();

		echo '<div class="alert alert-success">Exam Subject Data Deleted</div>';
	}
}

?>