<?php
	header('Cache-Control: no cache'); //no cache
	session_cache_limiter('private_no_expire'); // works
	session_cache_limiter('public');
	session_start();

	if(isset($_POST['submit'])){
		include('./Requests/library/Requests.php');
		Requests::register_autoloader();

		$id = $_POST['id'];
		$given = 1;

		
		$item = array('id' => $id, 'given' => $given);
		$response = Requests::post('http://127.0.0.1/apipro/give_assignment/update.php', array(), $item);
		var_dump($response->body);

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
			<li><a class="active" href="assignment_list.php">Assignment</a></li>
			<li><a href="project.php">Project</a></li>
			<li><a href="mark.php">Mark</a></li>
		</ul>
	</div>
	<div style="background-image: linear-gradient(180deg,#fff,#7effa4,60%,#d5d5d5);padding: 10px;margin-top: 10px;" id="attendanceid">
		<?php
			$url = "http://127.0.0.1/apipro/give_assignment/read.php";
			$json = file_get_contents($url);
			$contents = json_decode($json,true);
			$data = $contents['records'];
			$ar = array();
			$no=0;
			foreach ($data as $key => $value) {
				if($value['topic']=='111')continue;
				if($value['studentid']==$_SESSION['userid']){
					?>
					<div style="margin:auto;padding: 10px;background-color: #044c68;font-size: 24px;width:60%;margin-top: 10px;color: white;">
						<?php echo "NO: " . ++$no; ?>
						<div style="float: right;"><?php echo "Date of Submission: ";?><span style="color: #7fff6c;"><?php echo $value['deadline'];?></div></br>
						<div style="padding-top: 7px;"><?php echo "Topic: "; ?>
						<span style="color: #ff9bd3;"><?php echo $value['topic']; ?></span>
						<span style="color: #ff8e61;float: right;"><?php if($value['given']==0){echo "NO";}
									else echo "YES"; ?></span>
						<span style="float: right;">Submitted:&nbsp</span></br>
						<hr>
						<?php if($value['given']==0 && $value['deadline']>=date("Y-m-d")){
							?>
						<form enctype="multipart/form-data" method="post" action="">
							<input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
							<input type="file" name="file" multiple title="No More than 5 MB">or&nbsp&nbsp
							
							<input type="text" name="supportive" style="height: 25px;width: 300px;font-size: 20px;" placeholder="Enter drive link">
							<input type="hidden" name="id" value="<?php echo $value['id'];?>">
							<input type="submit" name="submit" value="SUBMIT" style="font-size: 15px;">
						</form>
						<?php } ?>
						</div>
					</div>
					<?php
				}
			}
		?>
	</div>
</body>
</html>