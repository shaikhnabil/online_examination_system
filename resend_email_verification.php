<?php

//resend_email_verification.php
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
<!-- resened email verification form -->
				<div class="row justify-content-md-center">
					<div class="col-sm-6">
						<span id="error"></span>
				      	<div class="card">
				      		<form method="post" class="form-horizontal" action="" id="resend_form">
					      		<div class="card-header" style="background-color:#8548d2 ;color:#f3e9ff;"><h3 class="text-center">Resend Verificaton Email</h3></div>
					      		<div class="card-body">
				      			
				      				<div class="row form-group">
				      					<label class="col-sm-4 col-form-label"><b>Email Address</b></label>
				      					<div class="col-sm-8">
					      					<input type="text" name="student_email_id" id="student_email_id" class="form-control" required data-parsley-type="email" data-parsley-trigger="keyup" />
					      				</div>
				      				</div>
				      			</div>
				      			<div class="card-footer text-center" style="background-color:#8548d2 ;color:#f3e9ff;">
				      				<input type="hidden" name="page" value="resend_email_verificaiton" />
				      				<input type="hidden" name="action" value="send_verificaton_email" />
				      				<input type="submit" name="submit" id="send_button" class="btn btn-info" value="Send" />
				      			</div>
				      		</form>
				      	</div>
				    </div>
				</div>
		    

<?php
//add footer file
include('footer.php');

?>

<script>

$(document).ready(function(){
//submit resend form
	$('#resend_form').parsley();

	$('#resend_form').on('submit', function(event){
		event.preventDefault();
		if($('#resend_form').parsley().isValid())
		{
			$.ajax({
				url:"ajax_action.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:"JSON",
				beforeSend:function()
                {
                    $('#send_button').attr('disabled', 'disabled');
                    $('#send_button').val('wait...');
                },
				success:function(data)
				{
					$('#send_button').attr('disabled', false);
                    $('#error').html(data.error);
                    $('#send_button').val('Send');
				}
			});
		}
	});

});

</script>