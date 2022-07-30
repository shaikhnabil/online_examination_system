<?php

//news.php
//add class file
include('admin/online_exam.php');
//create object
$object = new online_exam();
//check student login
if($object->is_student_login())
{
	header("location:".$object->base_url."student_dashboard.php");
}
//add header file
include('header.php');

?>

<!-- card for display news -->
		      	<h3 class="text-center my-5">Welcome</h3>
		      	<p class="text-center">If you are not login into system, click <a href="login.php">here</a></p>
		      	<div class="container">
			      	<div class="card mt-4 mb-4">
			      		<div class="card-header" style="background-color:#8548d2;color:#f3e9ff">Latest News</div>
			      		<div class="card-body">
			      		<?php
			      		$object->query = "
			      		SELECT * FROM exam
			      		WHERE exam_result_datetime != '0000-00-00 00:00:00' 
			      		ORDER BY exam_result_datetime ASC
			      		";

			      		$object->execute();

			      		if($object->row_count() > 0)
			      		{
			      			$result = $object->statement_result();
			      			foreach($result as $row)
			      			{
			      				if(time() < strtotime($row["exam_result_datetime"]))
			      				{
			      					echo '<p><b>'.$row["exam_title"].' </b>exam of <b>'.$object->Get_class_name($row["exam_class_id"]).'</b> result will publish on '.$row["exam_result_datetime"].'</p>';
			      				}
			      			}
			      		}
			      		else
			      		{
			      			echo '<p>No News Found</p>';
			      		}



			      		?>
			      		</div>
			      	</div>
			      </div>
		    

<?php
//add footer file
include('footer.php');

?>