<?php

//classes_action.php
//add class file
include('online_exam.php');
//create object
$object = new online_exam();
//forget password
if($_POST['page'] == 'forget_password') {
    if ($_POST['action'] == 'get_password') {
        sleep(2);
        $error = '';
        $data = array(
            ':user_email' => $_POST["user_email"]
        );

        $object->query = "SELECT * FROM user_register
WHERE user_email= :user_email";

        $object->execute($data);

        $total_row = $object->row_count();

        if ($total_row == 0) {
            $error = '<div class="alert alert-danger">Email Address not Found</div>';
        } else {
            $result = $object->statement_result();

            foreach ($result as $row) {
                if ($row["user_status"] == 'Enable') {
                    require_once('class/class.phpmailer.php');

                    $subject = 'Online Examination System Password Detail';

                    $body = '<p>Hello ' . $row["user_name"] . '.</p>
<p>For reset password visit <a href="' . $object->base_url . 'index.php" target="_blank"><b>' . $object->base_url . 'index.php</a></b> this link. Below you can find password details.</a></p>
<p><b>Password : </b>' . $row["user_password"] . '</p>
<p>In case if you have any difficulty please contact us.</p>
<p>Thank you,</p>
<p>Online Examination System</p>
';

                    $object->send_email($row["user_email"], $subject, $body);

                    $error = '<div class="alert alert-success">Hey <b>' . $row["user_name"] . '</b> your password details has been send to <b>' . $row["user_email"] . '</b> email address.</div>';
                } else {
                    $error = '<div class="alert alert-danger">Sorry, Your account has been disable, contact Admin</div>';
                }
            }
        }

        $output = array(
            'error' => $error
        );

        echo json_encode($output);
    }
}
