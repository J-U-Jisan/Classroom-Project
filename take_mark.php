<?php
	session_start();
	if (isset($_POST['submit'])) {
		include('./Requests/library/Requests.php');
		Requests::register_autoloader();

		$mark = $_POST['mark'];
		$id = $_POST['id'];

		$item = array('id' => $id, 'mark' => $mark);
		$response = Requests::post('http://127.0.0.1/apipro/marks/update.php', array(), $item);
		var_dump($response->body);
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
	<div style="background-image: linear-gradient(180deg,#fff,#7effa4,60%,#d5d5d5);padding: 10px;margin-top: 10px;text-align: center;min-height: 350px;">
		<h2><?php echo $_SESSION['topic']?></h2>
		<?php
			$url = "http://127.0.0.1/apipro/marks/read.php";
			$json = file_get_contents($url);
			$contents = json_decode($json,true);
			$data = $contents['records'];
			$no = 0;
			foreach ($data as $key => $value) {
				if($value['topic']==$_SESSION['topic'] && $value['teacherid']==$_SESSION['userid'] && $value['courseno']==$_SESSION['courseno']){
					?>
					<div style="background-color: #00ff22;margin:0 auto;padding: 10px;margin-top: 10px;width: 5%;font-size: 22px;display: inline-block;">
						<?php echo "NO: ". ++$no;?>
					</div>
					<div style="background: #00ff22; margin: 0 auto;display: inline; padding: 10px;width: 12%;margin-top:10px;font-size: 22px;">
						<?php echo "Roll: ". $value['studentid']; ?>
					</div>
					<div style="font-size: 22px;display: inline;margin: 0 auto;width: 30%;background-color: #00ff22;padding:10px; margin-top: 10px;margin-left: 5px;">
						<?php
							echo "Total Mark: " . $value['outof'];
						?>
					</div>
					<div style="font-size: 22px;display: inline;margin: 0 auto;width: 30%;background-color: #00ff22;padding:10px; margin-top: 10px;margin-left: 5px;">
						<form method="post" action="" style="display: inline;">
							<input type="hidden" name="id" value="<?php echo $value['id'];?>">
							Mark:
							<input type="text" name="mark" value="<?php echo $value['mark'];?>" style="font-size: 20px;width: 10%; height: 25px;text-align: center;">
							<input type="submit" name="submit" value="Submit" style="font-size: 20px;">
						</form>
					</div>
				</br>
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