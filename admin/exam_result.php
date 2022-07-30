<?php

//exam_result.php
//add class file
include('../admin/online_exam.php');
//add pdf file
require_once('../class/pdf.php');
//create object 
$object = new online_exam();

if(isset($_GET['ec']))
{
	$exam_id = $object->Get_exam_id($_GET['ec']);

	$object->query = "
	SELECT exam_class_id FROM exam 
	WHERE exam_id = '".$exam_id."'
	";

	$exam_data = $object->get_result();

	$exam_class_id = '';

	foreach($exam_data as $exam_row)
	{
		$exam_class_id = $exam_row["exam_class_id"];
	}

	$object->query = "
	SELECT student_id, student_roll_no FROM student_to_class 
	WHERE class_id = '".$exam_class_id."'
	";

	$class_data = $object->get_result();

	$output = '
	<h3 align="center">Exam - '.$object->Get_exam_name($exam_id).'</h3><br />
	<h3 align="center">Class - '.$object->Get_class_name($exam_class_id).'</h3>
	<br />
	<table width="100%" border="1" cellpadding="5" cellspacing="0">
		<tr>
			<td>Image</td>
			<td>Roll No.</td>
			<td>Student Name</td>
			<th>Total Marks</th>
			<th>Marks Obtain</th>
		</tr>
	';

	foreach($class_data as $class_row)
	{
		$student_name = '';
		$student_profile_img = '';
		$student_roll_no = $class_row["student_roll_no"];

		$object->query = "
		SELECT student_register.student_name, student_register.student_image FROM student_register 
		WHERE student_id = '".$class_row["student_id"]."'
		";
		$student_data = $object->get_result();

		foreach($student_data as $student_row)
		{
			$student_name = $student_row["student_name"];
			$student_profile_img = $student_row["student_image"];
		}

		$object->query = "
		SELECT * FROM subject_wise_exam
		INNER JOIN subject_to_class 
		ON subject_to_class.subject_to_class_id = subject_wise_exam.subject_to_class_id
		WHERE subject_wise_exam.exam_id = '$exam_id' 
		ORDER BY subject_wise_exam.exam_subject_id ASC
		";

		$result = $object->get_result();

		$total_mark = 0;

		$stm = 0;

		foreach($result as $row)
		{

			$subject = $row["subject_name"];

			$subject_total_mark = $row["subject_total_question"] * $row["marks_per_right_answer"];

			$stm = $stm + $subject_total_mark;

			$object->query = "
			SELECT SUM(exam_subject_question_answer.marks) AS total FROM exam_subject_question_answer 
			INNER JOIN exam_subject_question 
			ON exam_subject_question.exam_subject_question_id = exam_subject_question_answer.exam_subject_question_id 
			WHERE exam_subject_question.exam_subject_id = '".$row["exam_subject_id"]."' 
			AND exam_subject_question_answer.student_id = '".$class_row["student_id"]."'
			";

			$mark_result = $object->get_result(); 

			$subject_mark = 0;

			foreach($mark_result as $mark_row)
			{
				$subject_mark = $mark_row["total"];
			}

			$total_mark = $total_mark + $subject_mark;
		}

		$output .= '
		<tr>
			<td><img src="'.$student_profile_img.'" width="50" /></td>
			<td>'.$student_roll_no.'</td>
			<td>'.$student_name.'</td>
			<td>'.$stm.'</td>
			<td>'.$total_mark.'</td>
		</tr>
		';		
	}

	$output .= '</table></td></tr></table>';

	//echo $output;

	$pdf = new Pdf();

	$pdf->set_paper('letter', 'landscape');

	$file_name = 'Exam Result.pdf';

	$pdf->loadHtml($output);
	$pdf->render();
	$pdf->stream($file_name, array("Attachment" => false));
	exit(0);

}

?>