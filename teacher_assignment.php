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
		<span style="margin-left: 5%; font-size: 35px; font-weight: bold;">Teachers Zone</span>
		<a href="signout.php" class="hsign"><span style="float: right;font-size:23px;margin-right: 3%;">Sign Out</span></a>
		<span style="float: right;font-size: 23px;">|&nbsp</span>
		<a href="teacher.php" class="hsign"><span style="float: right;font-size: 23px;">
			<?php echo $_SESSION['userid'] . "&nbsp";?></span></a>
		</br>
		<span style="margin-left: 5%;size: 25px;font-weight: bold;">Connect teachers and students</span>	
	</div>
	<p style="font-size: 24px;font-weight: 800;padding: 10px;margin-top: 10px;text-align: center;background-color: #5b4141; color: white;"><?php 
		
		echo "Course No: " . $_SESSION['courseno'] . "&nbsp,&nbsp" ."Course Title : ". $_SESSION[$_SESSION['courseno']];?></p>
	<div style="background-color: white; box-shadow: 0px 1px 1px 1px #0ff; margin-top: -15px; padding-bottom: 15px;">
		
	</div>
	<div style="margin-top: 10px;">
		<ul>
			<li><a href="course_process.php">Students List</a></li>
			<li><a href="teacher_attendance.php">Attendance</a></li>
			<li><a class="active" href="teacher_assignment.php">Assignment</a></li>
			<li><a href="exam.php">Exam</a></li>
			<li><a href="project.php">Project</a></li>
		</ul>
	</div>
	<div style="background-image: linear-gradient(180deg,#fff,#7effa4,60%,#ec69cb);padding: 10px;margin-top: 10px;">
		<div id="list">
			<button class="button" title="Assign Assignment" onclick="assign()">+</button>
		<?php
			$url = "http://127.0.0.1/apipro/give_assignment/read.php";
			$json = file_get_contents($url);
			$contents = json_decode($json,true);
			$data = $contents['records'];
			$no = 0;
			$ar = array();
			
			foreach ($data as $key => $value) {
				if($value['teacherid']==$_SESSION['userid']){
					$flag = false;
					if(sizeof($ar)==0){
						array_push($ar, $value['topic']);
						$flag=true;
					}
					else{
						if($ar[sizeof($ar)-1]!=$value['topic']){
							array_push($ar, $value['topic']);
							$flag=true;
						}
					}
					if($flag){
						?>
						<div style="margin:auto;padding: 10px;background-color: #3e90b0;font-size: 24px;width:60%;margin-top: 10px;">
							<?php
								echo "No: ".++$no; 
							?>
							<span style="float: right;"><?php echo "Date of Submission: ".$value['deadline'];?></span>
							<br>
							<div style="padding-top: 7px;">
							<?php
								echo "Topic: ".$value['topic']; 
							?>
							</div>
						</div>
					<?php
					}
				}
			}
		?>
		</div>
		<div id="add" style="text-align: center;padding: 10px;">
			<h1>Assign Assignment</h1>
			<form method="post" action="">
				<label style="font-size: 25px;">Topic:</label>
				<input type="text" name="topic" style="height: 40px;width: 700px;font-size: 20px;"placeholder="Enter topic of assignment"></br>
				<label style="font-size: 25px;margin-left: -154px;">Date of Submission:</label>
				<input type="date" name="dateline" style="height: 40px;width: 400px;font-size: 27px;text-align: center;margin-top: 10px;"></br>
				<input type="submit" name="submit" value="Assign" style="height: 50px;width: 150px;font-size: 25px;margin-top: 10px;background-color: #3ccedd;">
			</form>
		</div>
	</div>
	<script type="text/javascript">
		function list() {
			document.getElementById("list").style.display = "block";
			document.getElementById("add").style.display = "none";
		}

		function assign() {
			document.getElementById("list").style.display = "none";
			document.getElementById("add").style.display = "block";
		}
	</script>
</body>
</html>