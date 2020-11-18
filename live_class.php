<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="nav.css">
	<title><?php echo $_SESSION['userid'].'(Teacher)'?></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://meet.jit.si/external_api.js"></script>
	<script>
		$(document).ready(function(){
			var domain = "meet.jit.si";
			var option = {
				roomName: "<?php echo $_SESSION['userid'] . $_SESSION['courseno']; ?>",
				width: '80%',
				height: 600,
				parentNode: document.querySelector('#meet')
			}
			var api = new JitsiMeetExternalAPI(domain, option);
		});
	</script>
</head>
<body style="background-color: #858ea1;" onload="list()">
	<div style="background-image: linear-gradient(90deg,#fff,#7effa4,60%,#ec69cb);">
		<span style="margin-left: 5%; font-size: 35px; font-weight: bold;">Teacher's Zone</span>
		<a href="signout.php" class="hsign"><span style="float: right;font-size:23px;margin-right: 3%;">Sign Out</span></a>
		<span style="float: right;font-size: 23px;">|&nbsp</span>
		<a href="teacher.php" class="hsign"><span style="float: right;font-size: 23px;">
			<?php echo $_SESSION['userid'] . "&nbsp";?></span></a>
		</br>
		<span style="margin-left: 5%;size: 25px;font-weight: bold;">Connect teachers and students</span>
	</div>
	<p style="font-size: 24px;font-weight: 800;padding: 10px;margin-top: 10px;text-align: center;background-color: #5b4141; color: white;"><?php 
		
		echo "Course No: " . $_SESSION['courseno'] . "&nbsp,&nbsp" ."Course Title : ". $_SESSION[$_SESSION['courseno']];?></p>
	
	<div style="margin-top: -10px;">
		<ul>
			<li><a href="teacher.php">Home</a></li>
			<li><a href="course_process.php">Students List</a></li>
			<li><a href="teacher_attendance.php">Attendance</a></li>
			<li><a href="teacher_assignment.php">Assignment</a></li>
			<li><a href="project.php">Project</a></li>
			<li><a href="mark.php">Mark</a></li>
			<li><a  class="active" href="live_class.php">Live Class</a></li>
		</ul>
	</div>
	
	<div style="margin-top: 10px; text-align: center;" id="meet">

	</div>
</body>
</html>