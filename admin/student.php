<?php

//student.php
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
	header("location:" . $object->base_url . "admin/result.php");
}
//add side navbar
include('header.php');

$object->query = "
SELECT * FROM exam_class 
WHERE class_status = 'Enable' 
ORDER BY class_name ASC
";

$result = $object->get_result();

?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Student Management</h1>

<!-- DataTables for display data -->
<span id="message"></span>
<div class="card shadow mb-4">
	<div class="card-header py-3" style="background-color:#8548d2;color:#f3e9ff;">
		<div class="row">
			<div class="col">
				<!-- heading -->
				<h6 class="m-0 font-weight-bold">Students List</h6>
			</div>
			<!-- add button -->
			<div class="col" style="text-align: right;">
				<button type="button" name="add_student" id="add_student" class="btn btn-info btn-circle btn-sm"><i class="fas fa-plus"></i></button>
			</div>
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="student_table" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Image</th>
						<th>Student Name</th>
						<th>Student Address</th>
						<th>Email Address</th>
						<th>Password</th>
						<th>Gender</th>
						<th>Date of Birth</th>
						<th>Added By</th>
						<th>Added On</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>
		</div>
	</div>
</div>

<?php
//add footer file
include('footer.php');
?>
<!-- add student modal -->
<div id="studentModal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="student_form" enctype="multipart/form-data">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="modal_title">Add Student</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<span id="form_message"></span>
					<div class="form-group">
						<label>Student Name</label>
						<input type="text" name="student_name" id="student_name" class="form-control" placeholder="Enter name" required data-parsley-pattern="/^[a-zA-Z0-9 \s]+$/" data-parsley-maxlength="30" data-parsley-trigger="keyup" />
					</div>
					<div class="form-group">
						<label>Student Address</label>
						<input type="text" name="student_address" id="student_address" class="form-control" placeholder="Enter address" required data-parsley-pattern="/^[a-zA-Z0-9\s]+$/" data-parsley-trigger="keyup" />
					</div>
					<div class="form-group">
						<label>Student Email</label>
						<input type="text" name="student_email_id" id="student_email_id" class="form-control" placeholder="Enter email" required data-parsley-type="email" data-parsley-maxlength="30" data-parsley-trigger="keyup" />
					</div>
					<div class="form-group">
						<label>Student Password</label>
						<input type="password" name="student_password" id="student_password" class="form-control" placeholder="Enter password" required data-parsley-length="[8, 16]" data-parsley-pattern="/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,16}$/" data-parsley-trigger="keyup" />
						<span class="text-muted">(Password must be atleast 8 digits long and contains one uppercase,one lowercase and one special character)</span>
					</div>
					<div class="form-group">
						<label>Gender</label>
						<select name="student_gender" id="student_gender" class="form-control" required>
							<option value="" selected="true" disabled="disabled">--Gender--</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
							<option value="Other">Other</option>
						</select>
					</div>
					<div class="form-group">
						<label>Date of Birth</label>
						<input type="text" name="student_dob" id="student_dob" class="form-control datepicker" readonly required data-parsley-trigger="keyup" />
					</div>
					<div class="form-group">
						<label form-label>Image</label><br />
						<!-- <input type="file" name="student_image" id="student_image" /> -->
						<div class="custom-file">
							<div>
								<input type="file" class="custom-file-input" id="student_image" name="student_image" data-parsley-pattern="([a-zA-Z0-9\s_\\.\-:])+(.png|.jpg|.gif|.jpeg)$" data-parsley-fileextension='jpg,jpeg,gif,png' required />
								<label class="custom-file-label" for="inputFile" id="inputGroupFile02">Choose file</label>
							</div>

							<span id="student_uploaded_image"></span>
						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="hidden_id" id="hidden_id" />
						<input type="hidden" name="action" id="action" value="Add" />
						<input type="submit" name="submit" id="submit_button" class="btn btn-info" value="Add" />
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
		</form>
	</div>
</div>

<script>
	$(document).ready(function() {
		//set datepicker format
		$('#student_dob').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true
		});
		//display data
		var dataTable = $('#student_table').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				url: "student_action.php",
				type: "POST",
				data: {
					action: 'fetch'
				}
			},
			"columnDefs": [{
				"targets": [9, 10],
				"orderable": false,
			}, ],
		});

		$('#add_student').click(function() {

			$('#student_form')[0].reset();

			$('#student_form').parsley().reset();

			$('#modal_title').text('Add Student');

			$('#action').val('Add');

			$('#submit_button').val('Add');

			$('#studentModal').modal('show');

			$('#form_message').html('');

			$('#student_image').attr('required', 'required');

			$('#student_uploaded_image').html('');

		});
		//image validation
		$('#student_image').change(function() {
			var extension = $('#student_image').val().split('.').pop().toLowerCase();
			if (extension != '') {
				if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
					alert("Invalid Image File");
					$('#student_image').val('');
					return false;
				}
			}
		});
		//get input of image
		$('#student_image').on('change', function() {
			//get the file name
			var fileName = $(this).val();
			//replace the "Choose a file" label
			$(this).next('.custom-file-label').html(fileName);
		})

		$('#student_form').parsley();
		//insert data
		$('#student_form').on('submit', function(event) {
			event.preventDefault();
			if ($('#student_form').parsley().isValid()) {
				$.ajax({
					url: "student_action.php",
					method: "POST",
					data: new FormData(this),
					dataType: 'json',
					contentType: false,
					processData: false,
					beforeSend: function() {
						$('#submit_button').attr('disabled', 'disabled');
						$('#submit_button').val('wait...');
					},
					success: function(data) {
						$('#submit_button').attr('disabled', false);
						if (data.error != '') {
							$('#form_message').html(data.error);
							$('#submit_button').val('Add');
						} else {
							$('#studentModal').modal('hide');
							$('#message').html(data.success);
							dataTable.ajax.reload();

							setTimeout(function() {

								$('#message').html('');

							}, 5000);
						}
					}
				})
			}
		});
		//edit data
		$(document).on('click', '.edit_button', function() {

			var student_id = $(this).data('id');

			$('#student_form').parsley().reset();

			$('#student_form')[0].reset();

			$('#form_message').html('');

			$('#student_uploaded_image').html('');

			$.ajax({

				url: "student_action.php",

				method: "POST",

				data: {
					student_id: student_id,
					action: 'fetch_single'
				},

				dataType: 'JSON',

				success: function(data) {

					$('#student_name').val(data.student_name);
					$('#student_address').val(data.student_address);
					$('#student_email_id').val(data.student_email_id);
					$('#student_password').val(data.student_password);
					$('#student_gender').val(data.student_gender);
					$('#student_dob').val(data.student_dob);
					$('#student_image').attr('required', false);

					$('#student_uploaded_image').html('<img src="' + data.student_image + '" class="img-fluid img-thumbnail" width="100"  /><input type="hidden" name="hidden_student_image" value="' + data.student_image + '" />');

					$('#modal_title').text('Edit Student Details');

					$('#action').val('Edit');

					$('#submit_button').val('Edit');

					$('#studentModal').modal('show');

					$('#hidden_id').val(student_id);

				}

			})

		});



		//change status
		$(document).on('click', '.status_button', function() {
			var id = $(this).data('id');
			var status = $(this).data('status');
			var next_status = 'Enable';
			if (status == 'Enable') {
				next_status = 'Disable';
			}
			if (confirm("Are you sure you want to " + next_status + " it?")) {

				$.ajax({

					url: "student_action.php",

					method: "POST",

					data: {
						id: id,
						action: 'change_status',
						status: status,
						next_status: next_status
					},

					success: function(data) {

						$('#message').html(data);

						dataTable.ajax.reload();

						setTimeout(function() {

							$('#message').html('');

						}, 5000);

					}

				})

			}
		});
		//delete data
		$(document).on('click', '.delete_button', function() {

			var id = $(this).data('id');

			if (confirm("Are you sure you want to remove it?")) {

				$.ajax({

					url: "student_action.php",

					method: "POST",

					data: {
						id: id,
						action: 'delete'
					},

					success: function(data) {

						$('#message').html(data);

						dataTable.ajax.reload();

						setTimeout(function() {

							$('#message').html('');

						}, 5000);

					}

				})

			}

		});

	});
</script>