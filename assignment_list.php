<?php
	
	session_start();

	//$upload_path = './image/';
    //$server_ip = gethostbyname(gethostname());
    //$upload_url = 'http://127.0.0.1/apipro/image/';
    //echo $server_ip;

	if(isset($_POST['submit'])){
		include('./Requests/library/Requests.php');
		Requests::register_autoloader();

		$id = $_POST['id'];
		$given = 1;

		
		$item = array('id' => $id, 'given' => $given);
		$response = Requests::post('http://127.0.0.1/apipro/give_assignment/update.php', array(), $item);
		var_dump($response->body);

		$teacherid = $_POST['teacherid'];
		$studentid = $_SESSION['userid'];
		$courseno = $_SESSION['courseno'];
		$name = $_SESSION['userid'].$_POST['id'];
  		
    	if($_FILES['file']['name']){
    		$tempfilename = $_FILES['file']['tmp_name'];
			$fileinfo = pathinfo($_FILES['file']['name']);
    		$extension = $fileinfo['extension'];
			$value = array('studentid' => $studentid, 'teacherid' => $teacherid, 'courseno' => $courseno, 'name' => $name, 'tempname' => $tempfilename, 'extension' => $extension);
			$response = Requests::post('http://127.0.0.1/apipro/upload.php',array(), $value);
		}
		else{
			$drive = $_POST['drive'];
			$value = array('studentid' => $studentid, 'teacherid' => $teacherid, 'courseno' => $courseno, 'name' =>$name, 'drive' => $drive);
			$response = Requests::post('http://127.0.0.1/apipro/upload_link.php',array(), $value);	
		}
		
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
				if($value['topic']=='111'|| $value['given']==1)continue;
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
			<li><a href="project_list.php">Project</a></li>
			<li><a href="mark_list.php">Mark</a></li>
			<li><a href="student_live_class.php"> Live Class</a></li>
		</ul>
	</div>
	<div style="background-image: linear-gradient(180deg,#fff,#7effa4,60%,#d5d5d5);padding: 10px;margin-top: 10px;min-height: 315px;" id="attendanceid">
		<?php
			$url = "http://127.0.0.1/apipro/give_assignment/read.php";
			$json = file_get_contents($url);
			$contents = json_decode($json,true);
			$data = $contents['records'];
			$ar = array();
			$no=0;
			foreach ($data as $key => $value) {
				if($value['topic']=='111'|| $value['deadline']=='0000-00-00')continue;
				if($value['studentid']==$_SESSION['userid'] && $value['courseno']==$_SESSION['courseno']){
					?>
					<div style="margin:auto;padding: 10px;background-color: #044c68;font-size: 24px;width:60%;margin-top: 10px;color: white;">
						<?php echo "NO: " . ++$no; ?>
						<div style="float: right;"><?php echo "Date of Submission: ";?><span style="color: #7fff6c;"><?php echo $value['deadline'];?></div></br>
						<div style="padding-top: 7px;"><?php echo "Topic: "; ?>
						<span style="color: #ff9bd3;"><?php echo $value['topic']; ?></span>
						<span style="color: #ff8e61;float: right;">
							<?php 
							if($value['given']==0)echo "NO";
							else echo "YES"; ?></span>
						<span style="float: right;">Submitted:&nbsp</span></br>
						<hr>
						<?php if($value['given']==0 && $value['deadline']>=date("Y-m-d")){
							?>
						<form enctype="multipart/form-data" method="post" action="">
							<input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
							<input type="file" name="file" multiple title="No More than 5 MB">or&nbsp&nbsp
							<input type="hidden" name="teacherid" value="<?php echo $value['teacherid'];?>">
							<input type="hidden" name="id" value="<?php echo $value['id'];?>">

							<input type="text" name="drive" style="height: 25px;width: 50%;font-size: 20px;" placeholder="Enter drive link">
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