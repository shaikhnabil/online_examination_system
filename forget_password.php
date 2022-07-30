<?php

//forget password.php
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
<!-- forget password form -->
				<div class="row justify-content-md-center">
					<div class="col-sm-6">
						<span id="error"></span>
				      	<div class="card">
				      		<form method="post" class="form-horizontal" action="" id="forget_password_form">
					      		<div class="card-header" style="background-color:#8548d2;color:#f3e9ff"><h3 class="text-center">Forget Password</h3></div>
					      		<div class="card-body" style="border: 2px groove #8548d2;">
				      			
				      				<div class="row form-group">
				      					<label class="col-sm-4 col-form-label"><b>Email Address</b></label>
				      					<div class="col-sm-8">
					      					<input type="text" name="student_email_id" id="student_email_id" class="form-control" placeholder="Enter email address" required data-parsley-type="email" data-parsley-trigger="keyup" />
					      				</div>
				      				</div>
									  <br />
				      				<input type="hidden" name="page" value="forget_password" />
				      				<input type="hidden" name="action" value="get_password" />
				      				<p class="text-center"><input type="submit" name="submit" id="forget_password_button" class="btn btn-info" value="Send" /></p>

				      				<p class="text-center"><a href="login.php">Login</a></p>
				      			</div>
				      			<!-- <div class="card-footer text-center" style="background-color:#fff;">
				      				<br />
				      				<input type="hidden" name="page" value="forget_password" />
				      				<input type="hidden" name="action" value="get_password" />
				      				<p><input type="submit" name="submit" id="forget_password_button" class="btn btn-info" value="Send" /></p>

				      				<p><a href="login.php">Login</a></p>
				      			</div> -->
				      		</form>
				      	</div>
				    </div>
				</div>
		    

<?php
//add footer file
include('footer.php');

?>

<script>
//submit data
$(document).ready(function(){

	$('#forget_password_form').parsley();

	$('#forget_password_form').on('submit', function(event){
		event.preventDefault();
		if($('#forget_password_form').parsley().isValid())
		{
			$.ajax({
				url:"ajax_action.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:"JSON",
				beforeSend:function()
                {
                    $('#forget_password_button').attr('disabled', 'disabled');
                    $('#forget_password_button').val('wait...');
                },
				success:function(data)
				{
					$('#forget_password_button').attr('disabled', false);
                    $('#error').html(data.error);
                    $('#forget_password_button').val('Send');
				}
			});
		}
	});

});

</script>