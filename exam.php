<?php

//exam.php
//add class file
include('admin/online_exam.php');
//create object
$object = new online_exam();
//check student login
if(!$object->is_student_login())
{
    header("location:".$object->base_url."");
}
//select students class 
$object->query = "
    SELECT class_id FROM student_to_class 
    WHERE student_id = '".$_SESSION["student_id"]."'
";

$result = $object->get_result();

$class_id = '';

foreach($result as $row)
{
    $class_id = $row["class_id"];
}
//add header file
include('header.php');
                
?>

                    <!-- Page Heading -->
                    <h1 class="h3 mt-4 mb-4 text-gray-800">Exam Management</h1>

                    <!-- DataTables -->
                    <span id="message"></span>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3" style="background-color:#8548d2 ;color:#f3e9ff;">
                        	<div class="row">
                            	<div class="col">
                            		<h6 class="m-0 font-weight-bold">Exam List</h6>
                            	</div>
                            	<div class="col" style="text-align: right;">
                            	</div>
                            </div>
                        </div>
                        <div class="card-body" style="border:2px groove #8548d2;">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="exam_table" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Exam Name</th>
                                            <th>Exam Duration</th>
                                            <th>Result Date & Time</th>
                                            <th>Status</th>
                                            <th>Timetable</th>
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

<div id="examtimetableModal" class="modal fade">
    <div class="modal-dialog" style="width: 100%; max-width: 1100px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title">Exam Schedule Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="exam_schedule_details"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
//fetch exam data request
	var dataTable = $('#exam_table').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"ajax_action.php",
			type:"POST",
			data:{page:'exam', action:'fetch', class_id:'<?php echo $class_id; ?>'}
		},
		"columnDefs":[
			{
				"targets":[4, 5],
				"orderable":false,
			},
		],
	});

//fetch timetable data
    $(document).on('click', '.view_timetable', function(){
        var exam_id = $(this).data('id');
        $.ajax({
            url:"ajax_action.php",
            method:"POST",
            data:{page:"exam", action:"fetch_timetable", exam_id:exam_id},
            success:function(data)
            {
                $('#examtimetableModal').modal('show');
                $('#exam_schedule_details').html(data);
            }
        })
    });
    

});
</script>