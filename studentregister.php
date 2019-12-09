<?php 
	session_start();
	if(isset($_POST['submit'])){
		include('./Requests/library/Requests.php');
		Requests::register_autoloader();

		$name= $_POST['name'];		
		$userid= $_POST['userid'];
		$password = $_POST['password'];
		$confirm = $_POST['confirm'];
		$admin_id = $_POST['admin_id'];
		$institute = $_POST['institution'];
		$contact_no = $_POST['contact'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		if($password != $confirm){
			$msg="<span style='color:red'>Password Not Matched</span>";
		}
		else{
			$data = array('userid' => $userid, 'password' => $password, 'admin_id' => $admin_id, 'email' => $email, 'institute' => $institute,'name' => $name,'contact_no' => $contact_no, 'address' => $address);		
			
			$response = Requests::post('http://127.0.0.1/apipro/students/create.php', array(), $data);
			var_dump($response->body);
			header('location:students_list.php');	
		}
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
		<span style="margin-left: 5%; font-size: 35px; font-weight: bold;">Teachers Zone</span>
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
			<a class="hsign" href="teachers_list.php">Teachers List</a>
			<a class="hsign" href="teacherregister.php">Admit Teachers</a>
			<a class="hsign" href="students_list.php">Students List</a>
			<a class="hsign" href="studentregister.php" style="color: blue;">Admit Student</a>
			<a class="hsign" href="course_list.php">Course List</a>
			<a class="hsign" href="courseregister.php">Add Course </a>
			<div class="dropdown">
		    <button class="dropbtn">Assign Course 
		      <span style="transform: rotate(90deg);display: block;float:right;margin-left: 8px;">&#x27A7;</span>
		    </button>
		    <div class="dropdown-content">
		      <a href="assign_course_teacher.php">to Teacher</a>
		      <a href="assign_course_student.php">to Student</a>
		      
		    </div>
		    </div>
		</nav>
	</header>

	<div id="Frame0">
		<form action="" method="post" name="register_form">
			<label>Full Name<font style="color:red;">*</font></label>
			<input type="text" name="name" id="name" placeholder="Enter Your Full Name..." required>
			<label>User Name<font style="color:red;">*</font></label>
			<input type="text" name="userid" id="userid" placeholder="Enter Your Roll Number..." required>
			<label>Password<font style="color:red;">*</font></label>
			<input type="password" name="password" id="password" placeholder="Enter a Password..." required>
			<label>Confirm Password<font style="color:red;">*</font></label>
			<?php if(isset($msg)){
				echo  $msg ;	
			} 
			?>
			<input type="password" name="confirm" id="confirm" placeholder="Enter a Password Same as before..." required>
			<input type="hidden" name="admin_id" id="admin_id" value="<?php echo $_SESSION['userid'];?>">
			<label>Institution<font style="color:red;">*</font></label>
			<input type="text" name="institution" id="institution" placeholder="Enter Your Institution..." required>
			<label>Contact No<font style="color:red;">*</font></label>
			<input type="text" name="contact" id="contact" placeholder="Enter Your Contact No..." required>
			<label>Email<font style="color:red;">*</font></label>
			<input type="email" name="email" id="email" placeholder="Enter Your Email..." required>
			<label>Address<font style="color:red;">*</font></label>
			<input type="text" name="address" id="address" placeholder="Enter Your address..." required>
			<input type="submit" name="submit"id="submit" value="Sign up now">
		</form>
	</div>
</body>
</html>