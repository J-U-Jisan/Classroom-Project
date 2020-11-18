<?php 
	session_start();
	if(isset($_POST['submit'])){
		include('./Requests/library/Requests.php');
		Requests::register_autoloader();

		$tmp=$_POST['submit'];
		$courseno="";
		$teacherid="";
		for($idx=0;$idx<strlen($tmp);$idx++){
			if($tmp[$idx]=='-' && $tmp[$idx+1]=='>'){
				$teacherid = substr($tmp, $idx+2);
				break;
			}
			else $courseno = $courseno . $tmp[$idx];
		}
		$admin_id = $_SESSION['userid'];
		$data = array('courseno' => $courseno, 'teacherid' => $teacherid, 'admin_id' => $admin_id);		
		
		$response = Requests::post('http://127.0.0.1/apipro/assign_teacher/delete.php', array(), $data);
		$rt= $response->body;
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
	
	<title><?php echo $_SESSION['userid'] . '(ADMIN)';?></title>
	<style>
		#submit:hover{
			transform: scale(1.2);
		}
	</style>
</head>
<body style="background-color: #858ea1;">
	<div style="background-color: #b0d791;">
		<span style="margin-left: 5%; font-size: 35px; font-weight: bold;">Teacher's Zone</span>
		<a href="signout.php" class="hsign"><span style="float: right;font-size:23px;margin-right: 3%;">Sign Out</span></a>
		<span style="float: right;font-size: 23px;">|&nbsp</span>
		<a href="admin.php" class="hsign"><span style="float: right;font-size: 23px;"><?php echo $_SESSION['userid'] . "&nbsp";?></span></a>
		</br>
		<span style="margin-left: 5%;size: 25px;font-weight: bold;">Connect teachers and students</span>	
	</div>
	</br>
	<header>
		<nav>
			<a class="hsign" href="admin.php">Home</a>
            <a class="hsign" href="classRoutineAdmin.php">Class Routine</a>
			<div class="dropdown" style="margin-left: 10px;">
		    <button class="dropbtn" style="color: blue;">Cancel Course 
		    <span style="transform: rotate(90deg);display: block;float:right;margin-left: 8px;">&#x27A7;</span>
		    </button>
		    <div class="dropdown-content">
		      <a href="#">from Teacher</a>
		      <a href="cancel_course_student.php">from Student</a>
		      
		    </div>
		    </div>
			<div class="dropdown" style="margin-left: 10px;">
		    <button class="dropbtn">Assign Course 
		    <span style="transform: rotate(90deg);display: block;float:right;margin-left: 8px;">&#x27A7;</span>
		    </button>
		    <div class="dropdown-content">
		      <a href="assign_course_teacher.php">to Teacher</a>
		      <a href="assign_course_student.php">to Student</a>
		      
		    </div>
		    </div>

		    <div class="dropdown" style="margin-left: 10px;">
		    <button class="dropbtn">Course 
		    <span style="transform: rotate(90deg);display: block;float:right;margin-left: 8px;">&#x27A7;</span>
		    </button>
		    <div class="dropdown-content">
		      <a href="courseregister.php">Add Course</a>
		      <a href="course_list.php">Course List</a>
		      <a href="delete_course.php">Delete Couse</a>
		    </div>
		    </div>

		    <div class="dropdown" style="margin-left: 10px;">
		    <button class="dropbtn">Student 
		    <span style="transform: rotate(90deg);display: block;float:right;margin-left: 8px;">&#x27A7;</span>
		    </button>
		    <div class="dropdown-content">
		      <a href="studentregister.php">Admit Student</a>
		      <a href="students_list.php">Student List</a>
		      <a href="delete_student.php">Delete Student</a>
		    </div>
		    </div>

		    <div class="dropdown">
		    <button class="dropbtn">Teacher 
		    <span style="transform: rotate(90deg);display: block;float:right;margin-left: 8px;">&#x27A7;</span>
		    </button>
		    <div class="dropdown-content">
		      <a href="teacherregister.php">Admit Teacher</a>
		      <a href="teachers_list.php">Teacher List</a>
		      <a href="delete_teacher.php">Delete Teacher</a>
		    </div>
		    </div>
			
		</nav>
	</header>

	<div style="min-height: 415px;">
	<div id="Frame0">
		<h2 style="text-align: center;">Cancel Course From Teacher</h2>
	</div>
	<div id="Frame0">
		<form action="" method="post">
			<?php
				$url = "http://127.0.0.1/apipro/assign_teacher/read.php";
				$json = file_get_contents($url);
				$contents = json_decode($json,true);
				$data  = $contents['records'];

				foreach ($data as $key =>$value){
					if($value['admin_id']== $_SESSION['userid']){
						$temp = $value['courseno']. '->' .$value['teacherid'];
						?>
					<button id="submit"type="submit" name="submit" value="<?php echo $temp;?>" style="width: 45%; margin-left: 27%;height: 45px;font-size: 20px;margin-top: 10px;" onclick="return ConfirmDelete();">
						<div style="width: 34%;background-color:#0cf75d;margin-left: -33%;display: inline-block;position: relative; top: -1px; padding: 9px;padding-bottom: 8px;"><?php echo $value['courseno'];?></div><div style="width: 60%;background-color:#1ce829;margin: 0 auto;display: inline-block;margin-right: -33%;padding: 9px;padding-bottom: 8px;position: relative;top: -1px;padding-right: 10px;"><?php echo $value['teacherid']; ?></div>
			
					</button>
				<!--
					<div style="margin:0 auto;text-align:center;font-size: 25px;margin-top: 10px;">

					<input type="hidden" name="courseno" value="<?php echo $value['courseno'];?>">
					<input type="hidden" name="teacherid" value="<?php echo $value['teacherid'];?>">
					<div style="padding:5px;width: 15%;margin: 0 auto;display: inline-block;margin-left:5%;"><input type="submit" name="submit"id="submit" value="Delete" onclick="return ConfirmDelete();"></div>
					</div>
				-->
						<?php
					}
				}

			?>
			</form>
	</div>
	</div>
	<footer>
	<div style="padding: 10px;margin-top: 10px;text-align: center;">
		
		<hr>
		<a href="home.php">Teacher's Zone </a>© Copyright 2019-<?php echo date("Y").' ';?> Jalal Uddin Jisan
		<br>
		Server time:<?php $timezone = date_default_timezone_set('Asia/Dhaka');
		$date = date('d/m/Y h:i:s A',time());
		echo ' '.$date;?>
	
	</div></footer>
	<script>
	    function ConfirmDelete()
	    {
	      var x = confirm("Are you sure you want to delete?");
	      if (x)
	          return true;
	      else
	        return false;
	    }
	</script>
</body>
</html>