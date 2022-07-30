<?php

//student_dashboard.php
//add class file
include('admin/online_exam.php');
//create object
$object = new online_exam();
//check student login
if (!$object->is_student_login()) {
	header("location:" . $object->base_url . "");
}
//add header file
include('header.php');

?>
<div class="card py-1">
	<div class="card-body text-center py-5" style="background-color:#8548d2;color:#f3e9ff">
		<h1><b>Online Examination System</b></h1>
	</div>
</div>

<div class="card">
	<!-- <img src="img/oes.jpg" class="card-img-top" alt="Image not displayed" height="300px" width="100%"> -->
	<div class="card-body ">
		<div class="card float-right" style="width: 31rem;height:365px">
			<div class="card-body">
				<video width="450" height="300" controls>
					<source src="img/exam_instruction.mp4" type="video/mp4">
					Your browser does not support the video.
				</video>
			</div>
		</div>
		<div class="card" style="width: 48rem;">
			<div class="card-body">
				<h3 class="card-title">Instruction For Online Examination System</h3>
				<p class="card-text py-1">
				<ul style="text-align: justify;">
					<li> Read the schedule(time table) carefully to attend exam on proper time.</li>
					<li> Attend the exam according to exam shedule.</li>
					<li> Once the exam time will start the start icon will be display in the action header and the exam status will be change to start.</li>
					<li> You need to click on next and previous button to load next and previous question or use navigation button to navigate questions.</li>
					<li> Once you click on submit button the answers will be submitted.</li>
					<li>Once the exam time is finished the start icon will disable and status change to completed.</li>
				</ul>
				</p>
				<a href="exam.php" class="btn btn-info float-right py-2">Next</a>
			</div>
		</div>


	</div>
</div>


<?php
//add footer file
include('footer.php');

?>

<script>
	$(document).ready(function() {




	});
</script>