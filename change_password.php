<?php

//change_password.php

include('admin/online_exam.php');

$object = new online_exam();

if(!$object->is_student_login())
{
    header("location:".$object->base_url."");
}

include('header.php');

?>

	<div class="containter">
		<div class="d-flex justify-content-center">
			<br /><br />
			
			<div class="card" style="margin-top:50px;margin-bottom: 100px;">
			<!-- <span id="error"></span> -->
        		<div class="card-header"  style="background-color:#8548d2;color:#f3e9ff;"><h4>Change Password</h4></div>
        		<div class="card-body" style="border: 2px groove #8548d2;">
	        		<form method="post"	id="change_password_form">
	        			<div class="form-group">
					        <label>Enter Password</label>
					        <input type="password" name="student_password" id="student_password" class="form-control" placeholder="Enter password" required data-parsley-length="[8, 16]" data-parsley-pattern="/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,16}$/" data-parsley-trigger="keyup" />
							<span class="text-muted">(Password must be atleast 8 digits long and contains one uppercase,one lowercase and one special character)</span>
					    </div>
					    <div class="form-group">
					        <label>Enter Confirm Password</label>
					        <input type="password" name="confirm_student_password" id="confirm_student_password" class="form-control" placeholder="Enter confirm password" required data-parsley-length="[8, 16]" data-parsley-pattern="/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,16}$/" data-parsley-trigger="keyup" />
					    </div>
					    <br />
					    <div class="form-group" style="text-align: center;">
					    	<input type="hidden" name="page" value="change_password" />
					    	<input type="hidden" name="action" value="change_password" />
					    	<input type="submit" name="change_password_btn" id="change_password_btn" class="btn btn-info" value="Change" />
					    </div>
	        		</form>
        		</div>
      		</div>
      		<br /><br />
      		<br /><br />
		</div>
	</div>
	<?php
	//add footer file
	include('footer.php');
	?>
</body>

</html>

<script>

$(document).ready(function(){

	$('#change_password_form').parsley();

	$('#change_password_form').on('submit', function(event){
		event.preventDefault();

		$('student_password').attr('required', 'required');

		$('#confirm_student_password').attr('required', 'required');

		$('#confirm_student_password').attr('data-parsley-equalto', '#student_password');

		if($('#change_password_form').parsley().validate())
		{
			$.ajax({
				url:"ajax_action.php",
				method:"POST",
				data:$(this).serialize(),
				dataType:"json",
				beforeSend:function()
				{
					$('#change_password_btn').attr('disabled', 'disabled');
					$('#change_password_btn').val('please wait...');
				},
				success:function(data)
				{
						$('#change_password_btn').attr('disabled', false);
                    	$('#error').html(data.error);
                    	$('#change_password_btn').val('Change');
						alert(data.error);
						location.reload(true);
					// $('#change_password').attr('disabled', false);
					// $('#change_password').val('Change');
					
				}
			})
		}
	});
	
});

</script>