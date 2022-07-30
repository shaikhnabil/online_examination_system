<?php

//forget_password.php

include('online_exam.php');

$object = new online_exam();

if ($object->is_login()) {
    header("location:" . $object->base_url . "admin/dashboard.php");
}
// include("header.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Forget Password</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../vendor/parsley/parsley.css" />

    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap-select/bootstrap-select.min.css" />

    <link rel="stylesheet" type="text/css" href="../vendor/datepicker/bootstrap-datepicker.css" />

    <link rel="stylesheet" type="text/css" href="../vendor/datetimepicker/bootstrap-datetimepicker.css" />
    <style>
        .bg-grey {
            background-color: #f6f6f6 !important;
            /*padding: 150px 25px;*/
        }
    </style>
</head>

<body id="page-top">
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow border border-bottom">
        <a class="navbar-brand" href="#">ONLINE EXAM</a>
    </nav>
    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- forget password form -->
        <div class="row justify-content-md-center my-5">
            <div class="col-sm-6">
                <span id="error"></span>
                <div class="card">
                    <form method="post" class="form-horizontal" action="" id="forget_password_form">
                        <div class="card-header" style="background-color:#8548d2;color:#f3e9ff">
                            <h3 class="text-center">Forget Password</h3>
                        </div>
                        <div class="card-body">

                            <div class="row form-group my-4">
                                <label class="col-sm-4 col-form-label"><b>Email Address</b></label>
                                <div class="col-sm-8">
                                    <input type="text" name="user_email" id="user_email" class="form-control" required data-parsley-type="email" data-parsley-trigger="keyup" />
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <br />
                            <input type="hidden" name="page" value="forget_password" />
                            <input type="hidden" name="action" value="get_password" />
                            <p><input type="submit" name="submit" id="forget_password_button" class="btn btn-primary" value="Send" /></p>

                            <p><a href="index.php">Login</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <!-- Footer -->
    <footer class="sticky-footer" style="background-color: #fff;color:#333;">
        <div class="container my-5">
            <div class="copyright text-center my-auto">
                <span style="font-size: 15px;">Copyright &copy; <?php echo date('Y'); ?></span>
            </div>
        </div>
    </footer>
    
    <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript" src="../vendor/parsley/dist/parsley.min.js"></script>

    <script type="text/javascript" src="../vendor/bootstrap-select/bootstrap-select.min.js"></script>

    <script type="text/javascript" src="../vendor/datepicker/bootstrap-datepicker.js"></script>

    <script type="text/javascript" src="../vendor/datetimepicker/bootstrap-datetimepicker.js"></script>

</body>

</html>

<script>
    $(document).ready(function() {

        $('#forget_password_form').parsley();

        $('#forget_password_form').on('submit', function(event) {
            event.preventDefault();
            if ($('#forget_password_form').parsley().isValid()) {
                $.ajax({
                    url: "forget_password_action.php",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    beforeSend: function() {
                        $('#forget_password_button').attr('disabled', 'disabled');
                        $('#forget_password_button').val('wait...');
                    },
                    success: function(data) {
                        $('#forget_password_button').attr('disabled', false);
                        $('#error').html(data.error);
                        $('#forget_password_button').val('Send');
                    }
                });
            }
        });

    });
</script>