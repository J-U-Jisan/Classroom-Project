<?php 
	session_start();
?>
<!DOCTYPE html>
<html>
<head>	
	<link rel="stylesheet" type="text/css" href="style.css">
	
	<title>
		<?php echo $_SESSION['userid'] . '(ADMIN)';?>
	</title>
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
            <a class="hsign" href="classRoutineAdmin.php">Class Routine</a>
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
	
	<div style="overflow: hidden;margin:10px;min-height: 415px;">
	<?php
		$url = "http://127.0.0.1/apipro/teachers/read.php";
		$json = file_get_contents($url);
		$contents = json_decode($json,true);
		$data = $contents['records'];
		
		$no=0;
		foreach ($data as $key => $value) {
			if($value['userid']=='111')continue;
			if($value['admin_id']==$_SESSION['userid']){
				?>
				<div class="teacherbox">
					<?php
						 echo "Teachers No: ".++$no . "<br>";
					 	 echo "Name: " . $value['name']; 
					 	 echo "<br>User Id: " . $value['userid'];
					 ?>
					<span style="float: right;"> <?php echo "Password: " . $value['password'];?></span>
					<?php
						echo "<br>Email: "  . $value['email'];
					?>
					<span style="float: right;"> <?php echo "Contact No: " . $value['contact_no'];?></span>
					<?php
						echo "<br>Address: " . $value['address'];
					?>
				</div>
				<?php

			}
		}
	?>
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