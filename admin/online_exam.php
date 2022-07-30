<?php

//online_exam.php
//class
class online_exam
{
	public $base_url;
	public $connect;
	public $query;
	public $statement;
	public $now;
	//this function is used to connect with database
	function online_exam()
	{
		if (file_exists(dirname(__DIR__) . '/install/db_info.inc')) {
			include(dirname(__DIR__) . '/install/db_info.inc');
			try {

				$this->connect = new PDO("mysql:host=$edb_host;dbname=$edb_name", $edb_user_name, $edb_password);

				//$this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				date_default_timezone_set('Asia/Kolkata');

				session_start();

				$this->now = date("Y-m-d H:i:s",  STRTOTIME(date('h:i:sa')));

				$this->base_url = $ebase_url;

				if ($this->if_table_exists()) {
					if ($this->if_master_exists()) {
						return true;
					} else {
						header('location:' . $ebase_url . 'install/set_up_master.php');
					}
				} else {
					$this->create_table();
					header('location:' . $ebase_url . 'install/set_up_master.php');
				}
			} catch (PDOException $e) {
				header('location:' . $ebase_url . 'install/set_up.php');
			}
		} else {
			$dir_array = explode("/", dirname($_SERVER['PHP_SELF']));
			if (end($dir_array) == 'admin') {
				header('location:../install/set_up.php');
			} else {
				header('location:install/set_up.php');
			}
		}
	}
	//for execute query
	function execute($data = null)
	{
		$this->statement = $this->connect->prepare($this->query);
		if ($data) {
			$this->statement->execute($data);
		} else {
			$this->statement->execute();
		}
	}
	//count returned rows by executing query
	function row_count()
	{
		return $this->statement->rowCount();
	}

	function statement_result()
	{
		return $this->statement->fetchAll();
	}
	//get result by execute query
	function get_result()
	{
		return $this->connect->query($this->query, PDO::FETCH_ASSOC);
	}


	//check user is login or not
	function is_login()
	{
		if (isset($_SESSION['user_id'])) {
			return true;
		}
		return false;
	}
	//check if user is teacher
	function is_teacher()
	{
		if (isset($_SESSION['user_type'])) {
			if ($_SESSION["user_type"] == 'Teacher') {
				return true;
			}
			return false;
		}
		return false;
	}

	//check if user is master user(Admin)
	function is_master_user()
	{
		if (isset($_SESSION['user_type'])) {
			if ($_SESSION["user_type"] == 'Admin' || $_SESSION["user_type"] == 'Teacher' ) {
				return true;
			}
			return false;
		}
		return false;
	}
	//check student is login or not
	function is_student_login()
	{
		if (isset($_SESSION['student_id'])) {
			return true;
		}
		return false;
	}
	//used to get clean input
	function clean_input($string)
	{
		$string = trim($string);
		$string = stripslashes($string);
		$string = htmlspecialchars($string);
		return $string;
	}
	//used to get class name
	function Get_class_name($class_id)
	{
		$this->query = "
		SELECT class_name FROM exam_class
		WHERE class_id = '$class_id'";
		$result = $this->get_result();
		foreach ($result as $row) {
			return $row["class_name"];
		}
	}
	//get subject already added in exam
	function Check_subject_already_added_in_exam($exam_id, $subject_to_class_id)
	{
		$this->query = "
		SELECT exam_subject_id FROM subject_wise_exam
		WHERE exam_id = '$exam_id' 
		AND subject_to_class_id = '$subject_to_class_id'
		";

		$this->execute();

		if ($this->row_count() > 0) {
			return true;
		}
		return false;
	}
	//get exam name
	function Get_exam_name($exam_id)
	{
		$this->query = "
		SELECT exam_title FROM exam 
		WHERE exam_id = '$exam_id'
		";
		$result = $this->get_result();
		foreach ($result as $row) {
			return $row["exam_title"];
		}
	}
	//get exam duration
	function Get_exam_duration($exam_id)
	{
		$this->query = "
		SELECT exam_duration FROM exam WHERE exam_id = '$exam_id'
		";
		$result = $this->get_result();
		foreach ($result as $row) {
			return $row["exam_duration"];
		}
	}
	//to get questions options
	function Get_question_option_data($exam_subject_question_id, $option_number)
	{
		$this->query = "
		SELECT question_option_title FROM question_option
		WHERE exam_subject_question_id = '$exam_subject_question_id' 
		AND question_option_number = '$option_number'
		";
		$result = $this->get_result();
		foreach ($result as $row) {
			return $row['question_option_title'];
		}
	}
	//check add question in this subject or not
	function Can_add_question_in_this_subject($exam_subject_id)
	{
		$this->query = "
		SELECT subject_total_question FROM subject_wise_exam 
		WHERE exam_subject_id = '$exam_subject_id'
		";

		$allow_question = 0;

		$result = $this->get_result();
		foreach ($result as $row) {
			$allow_question = $row["subject_total_question"];
		}

		$this->query = "
		SELECT * FROM exam_subject_question 
		WHERE exam_subject_id = '$exam_subject_id'
		";

		$this->execute();

		$total_question = $this->row_count();

		if ($total_question >= $allow_question) {
			return false;
		}

		return true;
	}

	//to get subject of class
	function Get_Class_subject($class_id)
	{
		$this->query = "
		SELECT subject_name FROM subject_to_class
		WHERE class_id = '$class_id' 
		AND subject_status = 'Enable'
		";
		$result = $this->get_result();
		$data = array();
		foreach ($result as $row) {
			$data[] = $row["subject_name"];
		}
		return $data;
	}
	//to get user name
	function Get_user_name($user_id)
	{
		$this->query = "
		SELECT * FROM user_register
		WHERE user_id = '" . $user_id . "'
		";
		$result = $this->get_result();
		foreach ($result as $row) {
			if ($row['user_type'] != 'Admin') {
				return $row["user_name"];
			} else {
				return 'Admin';
			}
		}
	}
	//to get subject name
	function Get_Subject_name($subject_to_class_id)
	{
		$this->query = "
		SELECT subject_name FROM subject_to_class 
		WHERE subject_to_class_id = '$subject_to_class_id'
		";
		$result = $this->get_result();
		foreach ($result as $row) {
			return $row["subject_name"];
		}
	}
//get student question answer option
	function Get_student_question_answer_option($exam_subject_question_id, $student_id)
	{
		$this->query = "
		SELECT student_answer_option FROM exam_subject_question_answer 
		WHERE exam_subject_question_id = '" . $exam_subject_question_id . "' 
		AND student_id = '" . $student_id . "'
		";
		$result = $this->get_result();
		foreach ($result as $row) {
			return $row["student_answer_option"];
		}
	}
//get question answer option
	function Get_question_answer_option($question_id)
	{
		$this->query = "
		SELECT exam_subject_question_answer FROM exam_subject_question 
		WHERE exam_subject_question_id = '" . $question_id . "' 
		";
		$result = $this->get_result();
		foreach ($result as $row) {
			return $row["exam_subject_question_answer"];
		}
	}
	//get right answer question mark
	function Get_question_right_answer_mark($exam_subject_id)
	{
		$this->query = "
		SELECT marks_per_right_answer FROM subject_wise_exam 
		WHERE exam_subject_id = '" . $exam_subject_id . "' 
		";
		$result = $this->get_result();
		foreach ($result as $row) {
			return $row["marks_per_right_answer"];
		}
	}
	//get wrong question answer mark
	function Get_question_wrong_answer_mark($exam_subject_id)
	{
		$this->query = "
		SELECT marks_per_wrong_answer FROM subject_wise_exam 
		WHERE exam_subject_id = '" . $exam_subject_id . "' 
		";
		$result = $this->get_result();
		foreach ($result as $row) {
			return $row["marks_per_wrong_answer"];
		}
	}
	//get exam id
	function Get_exam_id($exam_code)
	{
		$this->query = "
		SELECT exam_id FROM exam 
		WHERE exam_code = '$exam_code'
		";

		$result = $this->get_result();

		foreach ($result as $row) {
			return $row['exam_id'];
		}
	}
	//get exam subject id
	function Get_exam_subject_id($exam_subject_id)
	{
		$this->query = "
		SELECT exam_subject_id FROM subject_wise_exam
		WHERE subject_exam_code = '$exam_subject_id'
		";

		$result = $this->get_result();

		foreach ($result as $row) {
			return $row['exam_subject_id'];
		}
	}
	//mail function
	function send_email($receiver_email, $subject, $body)
	{
		$mail = new PHPMailer;

		$mail->IsSMTP();

		$mail->Host = 'smtp.mailtrap.io';

		$mail->Port = '2525';

		$mail->SMTPAuth = true;

		$mail->Username = 'fe3e034a42ff17';

		$mail->Password = '4fd805a2fcbdd4';

		$mail->SMTPSecure = 'tls';

		$mail->From = 'onlineexamination@gmail.com';

		$mail->FromName = 'Online Examination System';

		$mail->AddAddress($receiver_email, '');

		$mail->WordWrap = 50;

		$mail->IsHTML(true);

		$mail->Subject = $subject;

		$mail->Body = $body;

		$mail->Send();
	}

	//to get total class added
	function Get_total_classes()
	{
		$this->query = "
		SELECT COUNT(class_id) as Total 
		FROM exam_class
		WHERE class_status = 'Enable'
		";
		$result = $this->get_result();
		foreach ($result as $row) {
			return $row["Total"];
		}
	}

	

	//to get total subject added in class
	function Get_total_subject()
	{
		$this->query = "
		SELECT COUNT(subject_to_class_id) as Total 
		FROM subject_to_class 
		WHERE subject_status = 'Enable'
		";
		$result = $this->get_result();
		foreach ($result as $row) {
			return $row["Total"];
		}
	}
	//total of students
	function Get_total_student()
	{
		$this->query = "
		SELECT COUNT(student_id) as Total 
		FROM student_register 
		WHERE student_status = 'Enable'
		";
		$result = $this->get_result();
		foreach ($result as $row) {
			return $row["Total"];
		}
	}
	//get total exam
	function Get_total_exam()
	{
		$this->query = "
		SELECT COUNT(exam_id) as Total 
		FROM exam 
		";
		$result = $this->get_result();
		foreach ($result as $row) {
			return $row["Total"];
		}
	}
	//get total result publish
	function Get_total_result()
	{
		$this->query = "
		SELECT COUNT(exam_id) as Total 
		FROM exam 
		WHERE exam_result_datetime != '0000-00-00 00:00:00' 
		";
		$result = $this->get_result();
		foreach ($result as $row) {
			return $row["Total"];
		}
	}
	//check tables are exist in database or not
	function if_table_exists()
	{
		$this->query = "SHOW TABLES";

		$this->execute();

		if ($this->row_count() > 0) {
			return true;
		} else {
			return false;
		}
	}
	//if tables are not exist then run following quries to create tables
	function create_table()
	{
		$this->query = "
	    	CREATE TABLE exam_class(
			  class_id int(11) NOT NULL,
			  class_name varchar(30) COLLATE utf8_unicode_ci NOT NULL,
			  class_code varchar(50) COLLATE utf8_unicode_ci NOT NULL,
			  class_status enum('Enable','Disable') COLLATE utf8_unicode_ci NOT NULL,
			  class_created_on datetime NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
			CREATE TABLE exam(
			  exam_id int(11) NOT NULL,
			  exam_title varchar(30) COLLATE utf8_unicode_ci NOT NULL,
			  exam_class_id int(11) NOT NULL,
			  exam_duration varchar(30) COLLATE utf8_unicode_ci NOT NULL,
			  exam_status enum('Pending','Created','Started','Completed') COLLATE utf8_unicode_ci NOT NULL,
			  exam_created_on datetime NOT NULL,
			  exam_code varchar(50) COLLATE utf8_unicode_ci NOT NULL,
			  exam_result_datetime datetime NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
			CREATE TABLE exam_subject_question_answer (
			  answer_id int(11) NOT NULL,
			  student_id int(11) NOT NULL,
			  exam_subject_question_id int(11) NOT NULL,
			  student_answer_option enum('0','1','2','3','4') COLLATE utf8_unicode_ci NOT NULL,
			  marks varchar(11) COLLATE utf8_unicode_ci NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
			CREATE TABLE exam_subject_question(
			  exam_subject_question_id int(11) NOT NULL,
			  exam_id int(11) NOT NULL,
			  exam_subject_id int(11) NOT NULL,
			  exam_subject_question_title text COLLATE utf8_unicode_ci NOT NULL,
			  exam_subject_question_answer enum('1','2','3','4') COLLATE utf8_unicode_ci NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
			CREATE TABLE student_register(
			  student_id int(11) NOT NULL,
			  student_name varchar(30) COLLATE utf8_unicode_ci NOT NULL,
			  student_address tinytext COLLATE utf8_unicode_ci NOT NULL,
			  student_email_id varchar(30) COLLATE utf8_unicode_ci NOT NULL,
			  student_password varchar(16) COLLATE utf8_unicode_ci NOT NULL,
			  student_gender varchar(6) COLLATE utf8_unicode_ci NOT NULL,
			  student_dob date NOT NULL,
			  student_image varchar(50) COLLATE utf8_unicode_ci NOT NULL,
			  student_status enum('Enable','Disable') COLLATE utf8_unicode_ci NOT NULL,
			  student_email_verification_code varchar(100) COLLATE utf8_unicode_ci NOT NULL,
			  student_email_verified enum('No','Yes') COLLATE utf8_unicode_ci NOT NULL,
			  student_added_by varchar(30) COLLATE utf8_unicode_ci NOT NULL,
			  student_added_on datetime NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
			CREATE TABLE student_to_class(
			  student_to_class_id int(11) NOT NULL,
			  class_id int(11) NOT NULL,
			  student_id int(11) NOT NULL,
			  student_roll_no varchar(11) COLLATE utf8_unicode_ci NOT NULL,
			  added_on datetime NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
			CREATE TABLE subject_to_class(
			  subject_to_class_id int(11) NOT NULL,
			  class_id int(11) NOT NULL,
			  subject_code int(11) NOT NULL,
			  subject_name varchar(30) COLLATE utf8_unicode_ci NOT NULL,
			  subject_status enum('Enable','Disable') COLLATE utf8_unicode_ci NOT NULL,
			  added_on datetime NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
			CREATE TABLE subject_wise_exam(
			  exam_subject_id int(11) NOT NULL,
			  exam_id int(11) NOT NULL,
			  subject_to_class_id int(11) NOT NULL,
			  subject_total_question int(5) NOT NULL,
			  marks_per_right_answer varchar(3) COLLATE utf8_unicode_ci NOT NULL,
			  marks_per_wrong_answer varchar(3) COLLATE utf8_unicode_ci NOT NULL,
			  subject_exam_datetime datetime NOT NULL,
			  subject_exam_status enum('Pending','Started','Completed') COLLATE utf8_unicode_ci NOT NULL,
			  subject_exam_code varchar(50) COLLATE utf8_unicode_ci NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
			CREATE TABLE user_register(
			  user_id int(11) NOT NULL,
			  user_name varchar(30) COLLATE utf8_unicode_ci NOT NULL,
			  user_contact_no varchar(13) COLLATE utf8_unicode_ci NOT NULL,
			  user_email varchar(30) COLLATE utf8_unicode_ci NOT NULL,
			  user_password varchar(16) COLLATE utf8_unicode_ci NOT NULL,
			  user_profile varchar(50) COLLATE utf8_unicode_ci NOT NULL,
			  user_qualification varchar(30) COLLATE utf8_unicode_ci NOT NULL,
			  user_type enum('Admin','Teacher') COLLATE utf8_unicode_ci NOT NULL,
			  user_status enum('Enable','Disable') COLLATE utf8_unicode_ci NOT NULL,
			  user_created_on datetime NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
			CREATE TABLE contact(
				contact_id int(11) NOT NULL,
				name varchar(30) COLLATE utf8_unicode_ci NOT NULL,
				email varchar(30) COLLATE utf8_unicode_ci NOT NULL,
				subject varchar(30) COLLATE utf8_unicode_ci NOT NULL,
				message varchar(300) COLLATE utf8_unicode_ci NOT NULL,
				contact_on datetime NOT NULL
			  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
			ALTER TABLE exam_class
			  ADD PRIMARY KEY (class_id);
			ALTER TABLE exam
			  ADD PRIMARY KEY (exam_id);
			ALTER TABLE exam_subject_question_answer
			  ADD PRIMARY KEY (answer_id);
			ALTER TABLE exam_subject_question
			  ADD PRIMARY KEY (exam_subject_question_id);
			ALTER TABLE student_register
			  ADD PRIMARY KEY (student_id);
			ALTER TABLE student_to_class
			  ADD PRIMARY KEY (student_to_class_id);
			ALTER TABLE subject_to_class
			  ADD PRIMARY KEY (subject_to_class_id);
			ALTER TABLE subject_wise_exam
			  ADD PRIMARY KEY (exam_subject_id);
			ALTER TABLE user_register
			  ADD PRIMARY KEY (user_id);
			ALTER TABLE class
			  MODIFY class_id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
			ALTER TABLE exam
			  MODIFY exam_id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
			ALTER TABLE exam_subject_question_answer
			  MODIFY answer_id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
			ALTER TABLE exam_subject_question
			  MODIFY exam_subject_question_id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
			ALTER TABLE student_register
			  MODIFY student_id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
			ALTER TABLE student_to_class
			  MODIFY student_to_class_id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
			ALTER TABLE subject_to_class
			  MODIFY subject_to_class_id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;  
			ALTER TABLE subject_wise_exam
			  MODIFY exam_subject_id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
			ALTER TABLE user_register
			  MODIFY user_id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
    	";
		$this->execute();
	}

	function if_master_exists()
	{
		$this->query = "
		SELECT * FROM user_register 
		WHERE user_type = 'Admin' 
		AND user_status = 'Enable'
		";
		$this->execute();
		if ($this->row_count() > 0) {
			return true;
		} else {
			return false;
		}
	}
}
