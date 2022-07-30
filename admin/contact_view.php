<?php

//classes.php
//add class file
include('online_exam.php');
//create object
$object = new online_exam();
//check login
if (!$object->is_login()) {
	header("location:" . $object->base_url . "admin");
}

//check master user
if (!$object->is_master_user()) {
	header("location:" . $object->base_url . "admin/index.php");
}

include('header.php');

?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Contact Details</h1>

<!-- DataTales  -->
<span id="message"></span>
<div class="card shadow mb-4">
	<div class="card-header py-3 border border-bottom" style="background-color:#8548d2;color:#f3e9ff;">
		<div class="row">
			<div class="col">
				<h6 class="m-0 font-weight-bold">Contact List</h6>
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="contact_table" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Subject</th>
						<th>Message</th>
						<th>Contact_on</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>
		</div>
	</div>
</div>

<?php
include('footer.php');
?>


<script>
	$(document).ready(function() {
		//set fetch request to fetch contact data 
		var dataTable = $('#contact_table').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				url: "contact_action.php",
				type: "POST",
				data: {
					action: 'fetch'
				}
			},
			"columnDefs": [{
				"targets": [4],
				"orderable": false,
			}, ],
		});
	});
</script>