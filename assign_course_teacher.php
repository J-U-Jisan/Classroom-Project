<?php 
	session_start();
	if(isset($_POST['submit'])){
		include('./Requests/library/Requests.php');
		Requests::register_autoloader();

		$courseno = $_POST['courseno'];
		$teacherid = $_POST['teacherid'];
		$admin_id = $_POST['admin_id'];

		$data = array('courseno' => $courseno, 'teacherid' => $teacherid, 'admin_id' => $admin_id);		
		
		$response = Requests::post('http://127.0.0.1/apipro/assign_teacher/create.php', array(), $data);
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
		
		input[type=text],[type=password],[type=email],[type=address] select{
		  width: 100%;
		  padding: 12px 20px;
		  font-size:14px;
		  margin: 8px 0;
		  display: inline-block;
		  border: 1px solid #ccc;
		  border-radius: 4px;
		  box-sizing: border-box;

		}
		#submit{
			width:100%;
			padding:3px 15px;
			margin: 8px,0;
			border-radius: 10px;
			box-sizing: border-box;
			font-size:22px;
			background-color: #3973dd73;
		}
		#submit:hover{
			background-color: #245cc4;
			color:white;
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
		    <button class="dropbtn">Cancel Course 
		    <span style="transform: rotate(90deg);display: block;float:right;margin-left: 8px;">&#x27A7;</span>
		    </button>
		    <div class="dropdown-content">
		      <a href="cancel_course_teacher.php">from Teacher</a>
		      <a href="cancel_course_student.php">from Student</a>
		      
		    </div>
		    </div>
			<div class="dropdown" style="margin-left: 10px;">
		    <button class="dropbtn" style="color:blue;">Assign Course 
		    <span style="transform: rotate(90deg);display: block;float:right;margin-left: 8px;">&#x27A7;</span>
		    </button>
		    <div class="dropdown-content">
		      <a href="#">to Teacher</a>
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
		<h2 style="text-align: center;">Assign Course To Teacher</h2>
	</div>
	<div id="Frame0">
		<form action="" method="post">
			<label>Course No<font style="color:red;">*</font></label>
			<input type="text" name="courseno" id="courseno" placeholder="Enter Your Course No..." required>
			<label>Teacher Id<font style="color:red;">*</font></label>
			<input type="text" name="teacherid" id="teacherid" placeholder="Enter teacher id..." required>
			
			<input type="hidden" name="admin_id" id="admin_id" value="<?php echo $_SESSION['userid'];?>">
			<input type="submit" name="submit"id="submit" value="Submit">
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
</body>
</html>