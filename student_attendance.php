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
		<span style="margin-left: 5%; font-size: 35px; font-weight: bold;">Teachers Zone</span>
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
				if($value['topic']=='111'|| $value['given']==1)continue;
				if($value['deadline']<date("Y-m-d"))continue;
				if($value['studentid']==$_SESSION['userid']){
					if(sizeof($ar)==0){
						array_push($ar, $value['topic']);
						echo "Project: ".$value['topic'].", "."Date of Submission: ".$value['deadline'] . "&nbsp&nbsp&nbsp";
					}
					else{
						if($ar[sizeof($ar)-1]!=$value['topic']){
							array_push($ar, $value['topic']);
							echo "Project: ".$value['topic'].", "."Date of Submission: ".$value['deadline'] . "&nbsp&nbsp&nbsp";
						}
					}
				}
			}
		?>
		</marquee>
	</div>
	<div style="margin-top: 10px;">
		<ul>
			<li><a href="student.php">Home</a></li>
			<li><a class="active" href="student_attendance.php">Attendance</a></li>
			<li><a href="assignment_list.php">Assignment</a></li>
			<li><a href="project_list.php">Project</a></li>
			<li><a href="mark_list.php">Mark</a></li>
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
			$total = -1;
			$present = 0;
			foreach ($data as $key => $value) {
				if($_SESSION['userid']==$value['studentid'] && $_SESSION['courseno']==$value['courseno']){
					$total++;
					if($value['present']==1)$present++;
				}
			}
			$percent = ceil(($present*100)/$total);

			foreach ($data as $key => $value) {
				if($_SESSION['userid']==$value['studentid'] && $_SESSION['courseno']==$value['courseno'] && $value['day']!='0001-01-01'){
					?>
					<div style="background-color: #00ff4c;padding: 11px;font-size: 22px;width: 7%;float:left;margin-left: 8%;"><?php echo 'No: '.++$no;?></div>
					<div style="background-color: #b5a7e8;padding: 11px;font-size: 22px;width: 10%;float:left;overflow: hidden;"><?php echo $value['day']?></div>
					<div style="background-color: #00ff58;padding: 11px;font-size: 22px;width: 10%;float:left;overflow: hidden;"><?php echo $value['studentid']?></div>
					
					<button class="attendbutton" id="presentid" name="present" style="margin-left: 60px !important; <?php if($value['present']==1){?> background-color: #40ca23 !important;<?php } ?>" value="<?php echo $value['studentid'];?>">Present</button>
					<button class="attendbutton" id="absentid" name="absent" value="<?php echo $value['studentid'];?>" style="<?php if($value['present']==2){?> background-color: #40ca23 !important;<?php } ?>">Absent</button>

					<div style="margin-left: 75%;background-color: #00ff58;padding: 11px;font-size: 22px;width: 13%;overflow:hidden;"><?php 

					 $percent = ceil(($present*100)/$total);
					 echo "Percentage: ".$percent. "%"?></div>	
					</br>
				<?php
				}
			}
					
		?>

	</div>
</body>
</html>