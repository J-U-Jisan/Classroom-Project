<?php
	
	session_start();
	
	if (isset($_POST['studentbutton'])) {
		$_SESSION['day']=$_POST['studentbutton'];
		header('location:take_attendance.php');
	}

	if(isset($_POST['submit'])){
		include('./Requests/library/Requests.php');
		Requests::register_autoloader();
		$day = $_POST['day'];
		$courseno=$_SESSION['courseno'];
		$teacherid=$_SESSION['userid'];
		$admin_id=$_SESSION['adminid'];
		$present=0;

		$url = "http://127.0.0.1/apipro/assign_student/read.php";
		$json = file_get_contents($url);
		$contents = json_decode($json,true);
		$data = $contents['records'];
		foreach ($data as $key => $value) {
			if($value['courseno']==$courseno && $value['admin_id']==$admin_id){
				$item = array('day' => $day,'studentid' => $value['studentid'],'courseno' => $courseno, 'teacherid' => $teacherid,'present' => $present,'admin_id' => $admin_id);		
		
				$response = Requests::post('http://127.0.0.1/apipro/attendance/create.php', array(), $item);
				$rt=$response->body;
			}
		}
		?>
		<div>
			<script>
				window.alert(<?php echo $rt;?>);
			</script>
		</div>
		<?php 
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
			<li><a class="active" href="teacher_attendance.php">Attendance</a></li>
			<li><a href="teacher_assignment.php">Assignment</a></li>
			<li><a href="project.php">Project</a></li>
			<li><a href="mark.php">Mark</a></li>
			<li><a href="live_class.php">Live Class</a></li>
			
		</ul>
	</div>
	<div style="min-height: 375px;">
	<div style="background-image: linear-gradient(180deg,#fff,#7effa4,60%,#d5d5d5);padding: 10px;margin-top: 10px;text-align: center;" id="classid">
		<button class="button" title="Add Day" onclick="addday()">+</button>
		<?php
			$url = "http://127.0.0.1/apipro/attendance/read.php";
			$json = file_get_contents($url);
			$contents = json_decode($json,true);
			$data = $contents['records'];
			$no=0;
			$ar = array();
			foreach ($data as $key => $value) {
				if($value['day']=='0000-00-00')continue;
				if($value['admin_id']==$_SESSION['adminid'] && $value['teacherid']==$_SESSION['userid'] && $value['courseno']==$_SESSION['courseno']){
					array_push($ar, $value['day']);
				}
			}
			$day = array_unique($ar);
			foreach ($day as $key => $value) {
				?>
				<form method="post" action="">
					<button name="studentbutton"id="studentbutton" value="<?php echo $value; ?>" style="cursor: pointer;">
						<div style="display: inline-block;background-color: #91b0e1;width: 182px;margin-left: -26px;padding: 19px;"><?php echo 'Class No: '.++$no;?></div><div style="background-color: #508cea;display: inline-block;width: 308px;margin-right: -25px;padding-top: 19px;padding-bottom: 19px;"><?php echo $value;?></div>
					</button>
				</form>
				<?php
			}
		?>
	</div>
	<div style="background-image: linear-gradient(180deg,#fff,#7effa4,60%,#d5d5d5);padding: 10px;margin-top: 10px;text-align: center;" id="dateid">
		<h1>Add Class</h1>
		<form method="post" action="">
			<label style="font-size: 22px;">Date<font style="color:red;">*</font>:&nbsp&nbsp&nbsp</label>
			<input type="Date" name="day" style="width:20%;font-size: 25px;text-align: center;">
			<br>
			<input type="submit" name="submit" value="Save" style="width:10%;font-size: 22px;margin-top: 5px;background-color: #62b59d;padding: 6px;" onclick="addclass()">
		</form> 
	</div>
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