<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="nav.css">
	<title><?php echo $_SESSION['userid'].'(Teacher)'?></title>
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
			<li><a class="active" href="teacher_assignment.php">Assignment</a></li>
			<li><a href="project.php">Project</a></li>
			<li><a href="mark.php">Mark</a></li>
		</ul>
	</div>
	<div style="background-image: linear-gradient(180deg,#fff,#7effa4,60%,#ec69cb);padding: 10px;margin-top: 10px;min-height: 350px;">
		<h2 style="text-align: center;"><?php echo $_POST['topic'];?> </h2>
		<?php
			$url = "http://127.0.0.1/apipro/give_assignment/read.php";
			$json = file_get_contents($url);
			$contents = json_decode($json,true);
			$data = $contents['records'];

			foreach ($data as $key => $value) {
				$name= $value['studentid'].$value['id'];
				if($value['topic']==$_POST['topic'] && $value['teacherid']==$_SESSION['userid']){
					?>
					<div style="margin:0 auto;background-color: #015132;padding: 10px;margin-top:5px;font-size: 25px; color: #ead4ff;width: 50%;">
						Roll:<?php echo ' '.$value['studentid'];?>
						<div style="float: right;"><?php echo "Submitted: ";
							if($value['given']==0)echo "NO";
							else{
								echo "YES";
								$url = "http://127.0.0.1/apipro/read.php";
								$json = file_get_contents($url);
								$contents = json_decode($json,true);
								$item = $contents['records'];

								foreach ($item as $key => $val) {
									if($name == $val['name']){
										if($val['drive'])$link = $val['drive'];
										else $link = $val['file'];
										?>
										<button onclick="window.open('<?php echo $link;?>');">
										Open</button>
									
											
									
									<?php }
								}
							}
							?>
						</div>

					</div>
				<?php
				}
			}
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