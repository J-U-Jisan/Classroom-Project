<?php
	header('Cache-Control: no cache'); //no cache
	session_cache_limiter('private_no_expire'); // works
	session_cache_limiter('public');
	session_start();

	
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="nav.css">
	<title><?php echo $_SESSION['userid'].'(Teacher)'?></title>
</head>
<body style="background-color: #858ea1;">
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
			<li><a class="active" href="course_process.php">Students List</a></li>
			<li><a href="teacher_attendance.php">Attendance</a></li>
			<li><a href="teacher_assignment.php">Assignment</a></li>
			<li><a href="project.php">Project</a></li>
			<li><a href="mark.php">Mark</a></li>
			
		</ul>
	</div>
	<div style="background-image: linear-gradient(180deg,#fff,#7effa4,60%,#ec69cb);padding: 10px;margin-top: 10px;min-height: 350px;">
		<?php
			$url = "http://127.0.0.1/apipro/assign_student/read.php";
			$json = file_get_contents($url);
			$contents = json_decode($json,true);
			$data = $contents['records'];
			foreach ($data as $key => $value) {
				if($value['admin_id']==$_SESSION['adminid'] && $value['courseno']==$_SESSION['courseno']){
					$url = "http://127.0.0.1/apipro/students/read.php";
					$json = file_get_contents($url);
					$contents = json_decode($json,true);
					$st = $contents['records'];
					foreach ($st as $key => $item) {
						if($item['userid']==$value['studentid']){
							?>
							<button id="studentbutton" name="studentbutton">
								<div style="display: inline-block;background-color: #e19ba1;width: 182px;margin-left: -26px;padding: 19px;"><?php echo $item['userid'];?></div><div style="background-color: #e32d3d;display: inline-block;width: 308px;margin-right: -25px;padding-top: 19px;padding-bottom: 19px;"><?php echo $item['name'];?></div>
							</button>
							<?php
						}
					}
				}
			}
			//echo $_SESSION['1607084']. ' '. $_SESSION['1607070'].' ';
		?>
	</div>

	<footer>
	<div style="background-image: linear-gradient(180deg,#eabdbd,#7effa4,60%,#a2a87a);padding: 10px;margin-top: 10px;text-align: center;">
		
		<hr>
		<a href="home.php">Teacher's Zone </a>© Copyright 2019-<?php echo date("Y").' ';?> Jalal Uddin Jisan
		<br>
		Server time:<?php $timezone = date_default_timezone_set('Asia/Dhaka');
		$date = date('d/m/Y h:i:s A',time());
		echo ' '.$date;?>
	
	</div></footer>
</body>
</html>