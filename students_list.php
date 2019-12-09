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
		<span style="margin-left: 5%; font-size: 35px; font-weight: bold;">Teachers Zone</span>
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
			<a class="hsign" href="teachers_list.php">Teachers List</a>
			<a class="hsign" href="teacherregister.php">Admit Teachers </a>
			<a class="hsign" href="#" style="color:blue;">Students List</a>
			<a class="hsign" href="studentregister.php">Admit Student</a>
			<a class="hsign" href="course_list.php">Course List</a>
			<a class="hsign" href="courseregister.php">Add Course </a>
			<div class="dropdown">
		    <button class="dropbtn">Assign Course 
		    <span style="transform: rotate(90deg);display: block;float:right;margin-left: 8px;">&#x27A7;</span>
		    </button>
		    <div class="dropdown-content">
		      <a href="assign_course_teacher.php">to Teacher</a>
		      <a href="assign_course_student.php">to Student</a>
		      
		    </div>
		    </div>
		</nav>
	</header>
	
	<div style="overflow: hidden;margin:10px;">
	<?php
		$url = "http://127.0.0.1/apipro/students/read.php";
		$json = file_get_contents($url);
		$contents = json_decode($json,true);
		$data = $contents['records'];
		
		$no=0;
		foreach ($data as $key => $value) {
			if($value['admin_id']==$_SESSION['userid']){
				?>
				<div class="studentbox">
					<?php
						 echo "Students No: ".++$no . "<br>";
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
</body>
</html>