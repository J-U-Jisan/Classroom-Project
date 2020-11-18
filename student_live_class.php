<?php
	header('Cache-Control: no cache'); //no cache
	session_cache_limiter('private_no_expire'); // works
	session_cache_limiter('public');
	session_start();

	if(isset($_POST['coursebutton'])){
		$temp=$_POST['coursebutton'];
		$courseno="";
		$coursetitle="";
		for($idx=0;$idx<strlen($temp);$idx++){
			if($temp[$idx]=='-' && $temp[$idx+1]=='>'){
				$coursetitle = substr($temp, $idx+2);
				break;
			}
			else $courseno = $courseno . $temp[$idx];
		}
		$_SESSION['courseno'] = $courseno;
		$_SESSION[$courseno] = $coursetitle;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="nav.css">
	<title><?php echo $_SESSION['userid'].'(Student)'?></title>
</head>
<body style="background-color: #858ea1;">
	<div style="background-image: linear-gradient(90deg,#fff,#7effa4,60%,#ec69cb);">
		<span style="margin-left: 5%; font-size: 35px; font-weight: bold;">Teacher's Zone</span>
		<a href="signout.php" class="hsign"><span style="float: right;font-size:23px;margin-right: 3%;">Sign Out</span></a>
		<span style="float: right;font-size: 23px;">|&nbsp</span>
		<a href="student.php" class="hsign"><span style="float: right;font-size: 23px;">
			<?php echo $_SESSION['userid'] . "&nbsp";?></span></a>
		</br>
		<span style="margin-left: 5%;size: 25px;font-weight: bold;">Connect teachers and students</span>	
	</div>
	<p style="font-size: 24px;font-weight: 800;padding: 10px;margin-top: 10px;text-align: center;background-color: #5b4141; color: white;"><?php 
		echo "Course No: " . $_SESSION['courseno'] . "&nbsp,&nbsp" ."Course Title : ". $_SESSION[$_SESSION['courseno']];?></p>
	<div style="background-color: white; box-shadow: 0px 1px 1px 1px #0ff; margin-top: -15px; padding: 5px;color:red;">
		<marquee>
		<?php
			$url = "http://127.0.0.1/apipro/give_assignment/read.php";
			$json = file_get_contents($url);
			$contents = json_decode($json,true);
			$data = $contents['records'];
			$ar = array();
			foreach ($data as $key => $value) {
				if($value['topic']=='111'|| $value['given']==1 || $value['deadline']=='0000-00-00')continue;
				if($value['deadline']<date("Y-m-d"))continue;
				if($value['studentid']==$_SESSION['userid']){
					echo "Assignment: ".$value['topic'].", "."Date of Submission: ".$value['deadline'] . "&nbsp&nbsp&nbsp";
				}
			}
		?>
		<?php
			$url = "http://127.0.0.1/apipro/project/read.php";
			$json = file_get_contents($url);
			$contents = json_decode($json,true);
			$data = $contents['records'];
			$ar = array();
			foreach ($data as $key => $value) {
				if($value['topic']=='111'|| $value['given']==1 || $value['deadline']=='0000-00-00')continue;
				if($value['deadline']<date("Y-m-d"))continue;
				if($value['studentid']==$_SESSION['userid']){
					echo "Project: ".$value['topic'].", "."Date of Submission: ".$value['deadline'] . "&nbsp&nbsp&nbsp";
				}
			}
		?>
		</marquee>
	</div>
	<div style="margin-top: 10px;">
		<ul>
			<li><a href="student.php">Home</a></li>
			<li><a href="student_attendance.php">Attendance</a></li>
			<li><a href="assignment_list.php">Assignment</a></li>
			<li><a href="project_list.php">Project</a></li>
			<li><a href="mark_list.php">Mark</a></li>
			<li><a class="active" href="student_live_class.php">Live Class</a></li>
		</ul>
	</div>
	<div>
	</div>
	<div style="text-align: center; margin-top: 10px;">
		<?php 
			$url = "http://127.0.0.1/apipro/assign_teacher/read.php";
			$json = file_get_contents($url);
			$contents = json_decode($json,true);
			$data = $contents['records'];
			$class_link = "";
			foreach ($data as $key => $value) {
				if($value['courseno']==$_SESSION['courseno'] && $value['admin_id']==$_SESSION['adminid']){
					
					$teacherid = $value['teacherid'];
					$class_link = "https://meet.jit.si/" . $teacherid . $value['courseno'];
					break;		
				}
			}
		?>
		<iframe allow="camera; microphone; fullscreen; display-capture" src="<?php echo $class_link; ?>" style="height: 500px; width: 80%; border: 0px;"></iframe>
	</div>
</body>
</html>