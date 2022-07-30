<?php
//add class file
include('online_exam.php');
//create object 
$object = new online_exam();
//if already login then redirect to dashboard page
if ($object->is_login()) {
    header("location:" . $object->base_url . "admin/dashboard.php");
}
?>
<!-- login form -->
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #8548d2 !important;
        }

        form {
            border: 0px groove #73afba;
            /* border: 3px groove #f0ecee; */

            border-radius: 5px;
            max-width: 400px;
            margin: auto;
            /* background-color: #eae6e3; */
            color: #333;
        }

        .bg-grey {
            background-color: #f6f6f6;
        }

        input[type=email],
        input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            color: #ffffff;
            font-size: 15px;
            font-weight: bold;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 50%;
        }

        button:hover {
            opacity: 0.8;
            background-color: #cca898;
        }

        .login_header {
            text-align: center;
            margin: 24px 0 12px 0;
        }

        img.avatar {
            width: 40%;
            border-radius: 50%;
        }

        .container {
            padding: 25px;
        }

        a:link {
            text-decoration: none;
        }

        a:hover {
            color: #0437F2;
        }

        span.rg {
            float: right;
            padding-top: 25px 20px;

        }

        .logo {
            width: 200px;
            height: 40px;
        }

        /* .navbar {
            border: 2px solid #f1f1f1;
        } */
       

        /* Change styles for span and cancel button on extra small screens */
        @media screen and (max-width: 600px) {
            span.rg {
                display: block;
                float: none;
            }

        }

        .card {
            /* box-shadow: 0 5px 10px rgb(0 0 0 / 0.2); */
            box-shadow: 0 3px 10px rgb(0 0 0 / 0.5);
        }
    </style>



    <title>Online Examination Login</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../vendor/parsley/parsley.css" />

</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container-fluid">
            <!-- <a href="./index.php" class="navbar-brand">
                <img src="img/logo.png" class="logo" alt="ONLINE EXAM">
            </a> -->
            <a class="navbar-brand" href="#">ONLINE EXAM</a>
        </div>
    </nav>

    <span id="error"></span>
    <div class="container">
        <div class="row justify-content-md-center mt-2">
            <!-- <div class="col-sm-6 mt-2"> -->
            <!-- <span id="error"></span> -->
            <div class="card mt-3">
                <form method="post" class="form-horizontal" id="login_form">

                    <!-- <div class="card-header"  style="background-color:#7e2221; color: #f0ecee;">
                            <h3 class="text-center">Online Examination System</h3>
                        </div> -->
                    <div class="login_header">
                        <h1><b><i class="fas fa-user-lock"></i> Login</b></h1>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="email"><b>Email</b></label>
                            <input type="email" class="form-control" name="user_email" id="user_email" required autofocus data-parsley-type="email" data-parsley-trigger="keyup" placeholder="Enter Email Address" required />
                        </div>
                        <div class="form-group">
                            <label for="password"><b>Password</b></label>
                            <input type="password" class="form-control" name="user_password" id="user_password" required data-parsley-trigger="keyup" placeholder="Enter Password" autocomplete="off" maxlength="16" />
                        </div>
                        <div class="form-group">
                            <input type="checkbox" onclick="myFunction()"> Show Password <br>
                        </div>
                        <!-- <span class="mt-2"><a href="forget_password.php">Forgot password ?</a></span> -->
                        <div class="form-group mt-3">
                            <button type="submit" name="login_button" id="login_button" class="btn btn-primary btn-user btn-block ">Login</button>
                        </div>
                    </div>
                    <!-- <div class="card-footer text-center mt-0" style="background-color: #7e2221;">
                        </div> -->
                </form>
            </div>
            <!-- </div> -->
        </div>
    </div>
</body>



<!-- Bootstrap core JavaScript-->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../js/sb-admin-2.min.js"></script>
<script>
    //show/hide password function
    function myFunction() {
        var x = document.getElementById("user_password");
        if (x.type === "text") {
            x.type = "password";
        } else {
            x.type = "text";
        }
    }
</script>
<script type="text/javascript" src="../vendor/parsley/dist/parsley.min.js"></script>

</body>

</html>

<script>
    $(document).ready(function() {
        //validate form using parsely js
        $('#login_form').parsley();
        //send data using ajax to login_action page
        $('#login_form').on('submit', function(event) {
            event.preventDefault();
            if ($('#login_form').parsley().isValid()) {
                $.ajax({
                    url: "login_action.php",
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: 'json',
                    beforeSend: function() {
                        $('#login_button').attr('disabled', 'disabled');
                        $('#login_button').val('wait...');
                    },
                    success: function(data) {
                        $('#login_button').attr('disabled', false);
                        if (data.error != '') {
                            $('#error').html(data.error);
                            $('#login_button').val('Login');
                        } else {
                            window.location.href = data.url;
                        }
                    }
                })
            }
        });

    });

    
</script>