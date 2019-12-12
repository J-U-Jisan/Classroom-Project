<?php
	header('Cache-Control: no cache'); //no cache
	session_cache_limiter('private_no_expire'); // works
	session_cache_limiter('public');
	session_start();

	$present=0;
	if(isset($_POST['present'])){
		$present=1;
		$studentid=$_POST['present'];
	}
	elseif(isset($_POST['absent'])){
		$present=2;
		$studentid=$_POST['absent'];
	}
	elseif(isset($_POST['leave'])){
		$present=3;
		$studentid=$_POST['leave'];
	}

	if(isset($_POST['absent']) || isset($_POST['present']) || isset($_POST['leave'])){
		include('./Requests/library/Requests.php');
		Requests::register_autoloader();
		
		$day= $_SESSION['day'];
		
		$courseno=$_SESSION['courseno'];
		$teacherid=$_SESSION['userid'];
		
		$item = array('day' => $day, 'studentid' => $studentid,'courseno' => $courseno, 'present' => $present);			
		$response = Requests::post('http://127.0.0.1/apipro/attendance/update.php', array(), $item);
		var_dump($response->body);
		header('location:take_attendance.php');
	}
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
			<li><a href="course_process.php">Students List </a></li>
			<li><a class="active" href="teacher_attendance.php">Attendance</a></li>
			<li><a href="assignment.php">Assignment</a></li>
			<li><a href="exam.php">Exam</a></li>
			<li><a href="project.php">Project</a></li>
		</ul>
	</div>

	<div style="background-image: linear-gradient(180deg,#fff,#7effa4,60%,#d5d5d5);padding: 10px;margin-top: 10px;text-align: center;" id="attendanceid">
		<?php
			$url = "http://127.0.0.1/apipro/attendance/read.php";
			$json = file_get_contents($url);
			$contents = json_decode($json,true);
			$data = $contents['records'];
			$no=0;
			$val = $data;

			foreach ($data as $key => $value) {
				if($_SESSION['day']==$value['day'] && $_SESSION['userid']==$value['teacherid'] && $_SESSION['courseno']==$value['courseno']){
					$total = 0;
					$present = 0;
					foreach ($val as $key => $item) {
						if($value['studentid']==$item['studentid'] && $item['day']!='0001-01-01'){ 
							$total++;
							if($item['present']==1)
								$present++;
						}
					}
					?>
					<form method="post" action="">
					<div style="background-color: #00ff4c;padding: 11px;font-size: 22px;width: 7%;float:left;margin-left: 8%;"><?php echo 'No: '.++$no;?></div>
					<div style="background-color: #b5a7e8;padding: 11px;font-size: 22px;width: 10%;float:left;overflow: hidden;"><?php echo $value['day']?></div>
					<div style="background-color: #00ff58;padding: 11px;font-size: 22px;width: 10%;float:left;overflow: hidden;"><?php echo $value['studentid']?></div>
					
					<button class="attendbutton" id="presentid" name="present" style="margin-left: 13px !important; <?php if($value['present']==1){?> background-color: #40ca23 !important;<?php } ?>" value="<?php echo $value['studentid'];?>">Present</button>
					<button class="attendbutton" id="absentid" name="absent" value="<?php echo $value['studentid'];?>" style="<?php if($value['present']==2){?> background-color: #40ca23 !important;<?php } ?>">Absent</button>
					<button class="attendbutton" id="leaveid" name="leave" value="<?php echo $value['studentid'];?>" style="<?php if($value['present']==3){?> background-color: #40ca23 !important;<?php } ?>">Leave/Excuse</button>

					<div style="margin-left: 78%;background-color: #00ff58;padding: 11px;font-size: 22px;width: 13%;overflow:hidden;"><?php 

					 $percent = ceil(($present*100)/$total);
					 echo "Percentage: ".$percent. "%"?></div>
					</form>
					</br>
					
				<?php
				}
			}
		?>

	</div>
</body>
</html>