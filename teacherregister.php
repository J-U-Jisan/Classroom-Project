<?php 
	session_start();
	if(isset($_POST['submit'])){
		include('./Requests/library/Requests.php');
		Requests::register_autoloader();

		$name= $_POST['name'];		
		$userid= $_POST['userid'];
		$password = $_POST['password'];
		$confirm = $_POST['confirm'];
		$admin_id = $_POST['admin_id'];
		$institute = $_POST['institution'];
		$contact_no = $_POST['contact'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		if($password != $confirm){
			$msg="<span style='color:red'>Password Not Matched</span>";
		}
		else{
			$data = array('userid' => $userid, 'password' => $password, 'admin_id' => $admin_id, 'email' => $email, 'institute' => $institute,'name' => $name,'contact_no' => $contact_no, 'address' => $address);		
			
			$response = Requests::post('http://127.0.0.1/apipro/teachers/create.php', array(), $data);
			$rt= $response->body;
			?>
			<div>
				<script>
					window.alert(<?php echo $rt;?>);
				</script>
			</div>
		<?php
			//header('location:teachers_list.php');	
		}
	}
?>
<!DOCTYPE html>
<html>
<head>	
	<link rel="stylesheet" type="text/css" href="style.css">
	<title><?php echo $_SESSION['userid'] . '(ADMIN)';?></title>
	
	<style>
		
		input[type=text],[type=password],[type=email],[type=address] select{
		  width: 100%;
		  padding: 12px 20px;
		  font-size:14px;
		  margin: 8px 0;
		  display: inline-block;
		  border: 1px solid #ccc;
		  border-radius: 4px;
		  box-sizing: border-box;

		}
		#submit{
			width:100%;
			padding:3px 15px;
			margin: 8px,0;
			border-radius: 10px;
			box-sizing: border-box;
			font-size:22px;
			background-color: #3973dd73;
		}
		#submit:hover{
			background-color: #245cc4;
			color:white;
		}
	</style>
</head>
<body style="background-color: #858ea1;">
	<div style="background-color: #b0d791;">
		<span style="margin-left: 5%; font-size: 35px; font-weight: bold;">Teacher's Zone</span>
		<a href="signout.php" class="hsign"><span style="float: right;font-size:23px;margin-right: 3%;">Sign Out</span></a>
		<span style="float: right;font-size: 23px;">|&nbsp</span>
		<a href="admin.php" class="hsign"><span style="float: right;font-size: 23px;"><?php echo $_SESSION['userid'] . "&nbsp";?></span></a>
		</br>
		<span style="margin-left: 5%;size: 25px;font-weight: bold;">Connect teachers and students</span>	
	</div>
	</br>
	<header>
		<nav>
			<a class="hsign" href="admin.php">Home</a>
			
			<div class="dropdown" style="margin-left: 10px;">
		    <button class="dropbtn">Cancel Course 
		    <span style="transform: rotate(90deg);display: block;float:right;margin-left: 8px;">&#x27A7;</span>
		    </button>
		    <div class="dropdown-content">
		      <a href="cancel_course_teacher.php">from Teacher</a>
		      <a href="cancel_course_student.php">from Student</a>
		      
		    </div>
		    </div>
			<div class="dropdown" style="margin-left: 10px;">
		    <button class="dropbtn">Assign Course 
		    <span style="transform: rotate(90deg);display: block;float:right;margin-left: 8px;">&#x27A7;</span>
		    </button>
		    <div class="dropdown-content">
		      <a href="assign_course_teacher.php">to Teacher</a>
		      <a href="assign_course_student.php">to Student</a>
		      
		    </div>
		    </div>

		    <div class="dropdown" style="margin-left: 10px;">
		    <button class="dropbtn">Course 
		    <span style="transform: rotate(90deg);display: block;float:right;margin-left: 8px;">&#x27A7;</span>
		    </button>
		    <div class="dropdown-content">
		      <a href="courseregister.php">Add Course</a>
		      <a href="course_list.php">Course List</a>
		      <a href="delete_course.php">Delete Couse</a>
		    </div>
		    </div>

		    <div class="dropdown" style="margin-left: 10px;">
		    <button class="dropbtn">Student 
		    <span style="transform: rotate(90deg);display: block;float:right;margin-left: 8px;">&#x27A7;</span>
		    </button>
		    <div class="dropdown-content">
		      <a href="studentregister.php">Admit Student</a>
		      <a href="students_list.php">Student List</a>
		      <a href="delete_student.php">Delete Student</a>
		    </div>
		    </div>

		    <div class="dropdown">
		    <button class="dropbtn" style="color:blue;">Teacher 
		    <span style="transform: rotate(90deg);display: block;float:right;margin-left: 8px;">&#x27A7;</span>
		    </button>
		    <div class="dropdown-content">
		      <a href="teacherregister.php">Admit Teacher</a>
		      <a href="teachers_list.php">Teacher List</a>
		      <a href="delete_teacher.php">Delete Teacher</a>
		    </div>
		    </div>
		</nav>
	</header>
	<div style="min-height: 415px;">
		<div id="Frame0">
			<h2 style="text-align: center;">Teacher Registration</h2>
		</div>
		<div id="Frame0">
		<form action="" method="post" name="register_form">
			<label>Full Name<font style="color:red;">*</font></label>
			<input type="text" name="name" id="name" placeholder="Enter Your Full Name..." required>
			<label>User Name<font style="color:red;">*</font></label>
			<input type="text" name="userid" id="userid" placeholder="Enter Your User Name..." required>
			<label>Password<font style="color:red;">*</font></label>
			<input type="password" name="password" id="password" placeholder="Enter a Password..." required>
			<label>Confirm Password<font style="color:red;">*</font></label>
			<?php if(isset($msg)){
				echo  $msg ;	
			} 
			?>
			<input type="password" name="confirm" id="confirm" placeholder="Enter a Password Same as before..." required>
			<input type="hidden" name="admin_id" id="admin_id" value="<?php echo $_SESSION['userid'];?>">
			<label>Institution<font style="color:red;">*</font></label>
			<input type="text" name="institution" id="institution" placeholder="Enter Your Institution..." required>
			<label>Contact No<font style="color:red;">*</font></label>
			<input type="text" name="contact" id="contact" placeholder="Enter Your Contact No..." required>
			<label>Email<font style="color:red;">*</font></label>
			<input type="email" name="email" id="email" placeholder="Enter Your Email..." required>
			<label>Address<font style="color:red;">*</font></label>
			<input type="text" name="address" id="address" placeholder="Enter Your address..." required>
			<input type="submit" name="submit"id="submit" value="Sign up now">
		</form>
		</div>
	</div>
	<footer>
	<div style="padding: 10px;margin-top: 10px;text-align: center;">
		
		<hr>
		<a href="home.php">Teacher's Zone </a>© Copyright 2019-<?php echo date("Y").' ';?> Jalal Uddin Jisan
		<br>
		Server time:<?php $timezone = date_default_timezone_set('Asia/Dhaka');
		$date = date('d/m/Y h:i:s A',time());
		echo ' '.$date;?>
	
	</div></footer>
</body>
</html>