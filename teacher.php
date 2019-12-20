<?php
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

		header('location:course_process.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
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
	<div style="background-image: linear-gradient(180deg,#fff,#99bee6,60%,#e1b7b7);margin-top: 5px; padding-bottom: 15px;">
		<h2 style="font-size: 22px !important;padding: 10px;text-align: center;">Course List</h2>

		<?php
			$url = "http://127.0.0.1/apipro/assign_teacher/read.php";
			$json = file_get_contents($url);
			$contents = json_decode($json,true);
			$data = $contents['records'];
			foreach ($data as $key => $value) {
				if($value['teacherid']==$_SESSION['userid'] && $value['admin_id']==$_SESSION['adminid']){
					$url = "http://127.0.0.1/apipro/courses/read.php";
					$json = file_get_contents($url);
					$contents = json_decode($json,true);
					$title = $contents['records'];

					foreach ($title as $key => $course) {
						if($course['courseno']==$value['courseno'] && $course['admin_id']==$value['admin_id']){
								
								?>
								<form method="post" action="">
									<button id="coursebutton" name="coursebutton" value="<?php echo $value['courseno'].'->'.$course['coursetitle'];?>"> <?php echo "Course No: " . $value['courseno'] . "</br>Course Title: " . $course['coursetitle'];
									?></button>			
								</form>
						<?php
						}
					}
					
				}
			}
		?>
		
	</div>
</body>
</html>