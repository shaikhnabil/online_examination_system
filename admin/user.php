<?php

//user.php
//add class file
include('online_exam.php');
//create object
$object = new online_exam();
//check login
if (!$object->is_login()) {
    header("location:" . $object->base_url . "admin");
}
if ($object->is_teacher()) {
    header("location:" . $object->base_url . "admin/result.php");
}
if (!$object->is_master_user()) {
    header("location:" . $object->base_url . "admin/result.php");
}
//add side navbar
include('header.php');

?>

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">User Management</h1>

<!-- DataTables -->
<span id="message"></span>
<div class="card shadow mb-4">
    <div class="card-header py-3" style="background-color:#8548d2;color:#f3e9ff;">
        <div class="row">
            <div class="col">
                <h6 class="m-0 font-weight-bold">Users List</h6>
            </div>
            <div class="col" style="text-align:right">
                <button type="button" name="add_user" id="add_user" class="btn btn-info btn-circle btn-sm"><i class="fas fa-plus"></i></button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="user_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>User Name</th>
                        <th>User Contact No.</th>
                        <th>User Email</th>
                        <!-- <th>User Password</th> -->
                        <th>User Qualification</th>
                        <th>Created On</th>
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
<!-- modal for add data -->
<div id="userModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="user_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title">Add user Data</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <span id="form_message"></span>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">User Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="user_name" id="user_name" placeholder="Enter Username" class="form-control" required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="30" data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">User Contact No. <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="user_contact_no" id="user_contact_no" class="form-control" placeholder="Enter Contact No" data-parsley-type="integer" data-parsley-minlength="10" data-parsley-maxlength="12" data-parsley-trigger="keyup" required />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">User Email <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="user_email" placeholder="Enter Email" id="user_email" class="form-control" required data-parsley-type="email" data-parsley-maxlength="30" data-parsley-trigger="keyup" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">User Password <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="password" name="user_password" id="user_password" class="form-control" placeholder="Enter Password" required data-parsley-length="[8, 16]" data-parsley-pattern="/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,16}$/" data-parsley-trigger="keyup" />
                                <span class="text-muted">(Password must be atleast 8 digits long and contains one uppercase,one lowercase and one special character)</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">User Profile <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="user_image" name="user_image" data-parsley-pattern="([a-zA-Z0-9\s_\\.\-:])+(.png|.jpg|.gif|.jpeg)$" data-parsley-fileextension='jpg,jpeg,gif,png' required />
                                    <label class="custom-file-label" for="inputFile">Choose file</label>
                                </div>
                                <span id="user_uploaded_image"></span>
                            </div>
                        </div>
                    </div>

                    <!--
                    <input type="file" name="user_image" id="user_image" class="input-group custom-form-control" /> -->
                    <!-- Default dropright button -->
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">User Qualification<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select class="custom-select mb-3" name="user_qualification" id="user_qualification" required>
                                    <option selected value="" selected="true" disabled="disabled">--Qualification--</option>
                                    <option value="SSC">SSC</option>
                                    <option value="HSC">HSC</option>
                                    <option value="Graduate">Graduate</option>
                                    <option value="Post-Graduate">Post-Graduate</option>
                                    <option value="PHD">PHD</option>
                                </select>
                            </div>
                        </div>
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
    //function for display data
    $(document).ready(function() {

        var dataTable = $('#user_table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                url: "user_action.php",
                type: "POST",
                data: {
                    action: 'fetch'
                }
            },
            "columnDefs": [{
                "targets": [0, 4, 7],
                "orderable": false,
            }, ],
        });

        $('#add_user').click(function() {

            $('#user_form')[0].reset();

            $('#user_form').parsley().reset();

            $('#modal_title').text('Add Data');

            $('#action').val('Add');

            $('#submit_button').val('Add');

            $('#userModal').modal('show');

            $('#form_message').html('');

            $('#user_uploaded_image').html('');

        });
        //upload image file validation
        $('#user_image').change(function() {
            var extension = $('#user_image').val().split('.').pop().toLowerCase();
            if (extension != '') {
                if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                    alert("Invalid Image File");
                    $('#user_image').val('');
                    return false;
                }
            }
        });
        //get input of image
        $('#user_image').on('change', function() {
            //get the file name
            var fileName = $(this).val();
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        })


        //insert data
        $('#user_form').parsley();

        $('#user_form').on('submit', function(event) {
            event.preventDefault();
            if ($('#user_form').parsley().isValid()) {
                $.ajax({
                    url: "user_action.php",
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
                            $('#userModal').modal('hide');
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
        //edit user data
        $(document).on('click', '.edit_button', function() {

            var user_id = $(this).data('id');

            $('#user_form').parsley().reset();

            $('#form_message').html('');

            $.ajax({

                url: "user_action.php",

                method: "POST",

                data: {
                    user_id: user_id,
                    action: 'fetch_single'
                },

                dataType: 'JSON',

                success: function(data) {

                    $('#user_name').val(data.user_name);
                    $('#user_email').val(data.user_email);
                    $('#user_contact_no').val(data.user_contact_no);
                    $('#user_password').val(data.user_password);

                    $('#user_uploaded_image').html('<img src="' + data.user_profile + '" class="img-fluid img-thumbnail" width="75" height="75" /><input type="hidden" name="hidden_user_image" value="' + data.user_profile + '" />');
                    $('#user_qualification').val(data.user_qualification);
                    $('#modal_title').text('Edit Data');

                    $('#action').val('Edit');

                    $('#submit_button').val('Edit');

                    $('#userModal').modal('show');

                    $('#hidden_id').val(user_id);

                }

            })

        });
        //enable or disable status
        $(document).on('click', '.status_button', function() {
            var id = $(this).data('id');
            var status = $(this).data('status');
            var next_status = 'Enable';
            if (status == 'Enable') {
                next_status = 'Disable';
            }
            if (confirm("Are you sure you want to " + next_status + " it?")) {

                $.ajax({

                    url: "user_action.php",

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
        //delete user data
        $(document).on('click', '.delete_button', function() {

            var id = $(this).data('id');

            if (confirm("Are you sure you want to remove it?")) {

                $.ajax({

                    url: "user_action.php",

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