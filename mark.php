<?php
	session_start();
/*
	if (isset($_POST['studentbutton'])) {
		$_SESSION['day']=$_POST['studentbutton'];
		header('location:take_attendance.php');
	}
*/
	if(isset($_POST['submit'])){
		include('./Requests/library/Requests.php');
		Requests::register_autoloader();
		$topic = $_POST['topic'];
		$courseno=$_SESSION['courseno'];
		$teacherid=$_SESSION['userid'];
		$admin_id=$_SESSION['adminid'];
		$mark=0;

		$url = "http://127.0.0.1/apipro/assign_student/read.php";
		$json = file_get_contents($url);
		$contents = json_decode($json,true);
		$data = $contents['records'];
		foreach ($data as $key => $value) {
			if($value['courseno']==$courseno && $value['admin_id']==$admin_id){
				$item = array('teacherid' => $teacherid,'studentid' => $value['studentid'],'courseno' => $courseno, 'topic' => $topic,'mark' => $mark);		
		
				$response = Requests::post('http://127.0.0.1/apipro/marks/create.php', array(), $item);
				var_dump($response->body);
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="nav.css">
	<title><?php echo $_SESSION['userid'].'(Teacher)'?></title>
</head>
<body style="background-color: #858ea1;" onload="addclass()">
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
			<li><a href="course_process.php">Students List </a></li>
			<li><a href="teacher_attendance.php">Attendance</a></li>
			<li><a href="teacher_assignment.php">Assignment</a></li>
			<li><a href="project.php">Project</a></li>
			<li><a class="active" href="mark.php">Mark</a></li>
			
		</ul>
	</div>
	<div style="background-image: linear-gradient(180deg,#fff,#7effa4,60%,#d5d5d5);padding: 10px;margin-top: 10px;text-align: center;" id="classid">
		<button class="button" title="Add Subject" onclick="addday()">+</button>
		<?php
			$url = "http://127.0.0.1/apipro/marks/read.php";
			$json = file_get_contents($url);
			$contents = json_decode($json,true);
			$data = $contents['records'];
			$no=0;
			$ar = array();
			foreach ($data as $key => $value) {
				if($value['topic']=='111')continue;
				if($value['teacherid']==$_SESSION['userid'] && $value['courseno']==$_SESSION['courseno']){
					array_push($ar, $value['topic']);
				}
			}
			$topic = array_unique($ar);
			foreach ($topic as $key => $value) {
				?>
				<form method="post" action="take_mark.php">
					<button name="markbutton"id="studentbutton" value="<?php echo $value; ?>">
						<div style="display: inline-block;background-color: #91b0e1;width: 100px;margin-left: -26px;padding: 19px;"><?php echo 'No: '.++$no;?></div><div style="background-color: #508cea;display: inline-block;width: 390px;margin-right: -25px;padding-top: 19px;padding-bottom: 19px;"><?php echo $value;?></div>
					</button>
				</form>
				<?php
			}
		?>
	</div>
	<div style="background-image: linear-gradient(180deg,#fff,#7effa4,60%,#d5d5d5);padding: 10px;margin-top: 10px;text-align: center;" id="dateid">
		<h1>Add Subject</h1>
		<form method="post" action="take_mark.php">
			<label style="font-size: 22px;">Name<font style="color:red;">*</font>:&nbsp&nbsp&nbsp</label>
			<input type="text" name="topic" style="width:40%;height:50px;font-size: 25px;" placeholder="Enter name">
			<br>
			<input type="submit" name="submit" value="Save" style="width:10%;font-size: 22px;margin-top: 5px;background-color: #62b59d;padding: 6px;" onclick="addclass()">
		</form> 
	</div>
	

	<script type="text/javascript">
		function addday() {
			document.getElementById("dateid").style.display = "block";
			document.getElementById("classid").style.display = "none";
		}

		function addclass() {
			document.getElementById("dateid").style.display = "none";
			document.getElementById("classid").style.display = "block";
		}

	</script>
</body>
</html>