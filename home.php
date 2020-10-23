<?php
	header('Cache-Control: no cache'); //no cache
	session_cache_limiter('private_no_expire'); // works
	session_cache_limiter('public');
	session_start();
	if(isset($_POST['submit'])){
		if($_POST['type']=="Admin"){
			$url = "http://127.0.0.1/apipro/admins/read.php";
			$json = file_get_contents($url);
			$contents = json_decode($json,true);
			$data = $contents['records'];
			foreach ($data as $key => $value) {
				if($value['userid']==$_POST['user'] && $value['password']==$_POST['password']){
					$_SESSION['userid']=$value['userid'];
					header('location:admin.php');
				}
			}
			$msg="<span style='color:red'>Incorrect Username or Password</span>";
		}
		elseif($_POST['type']=="Teacher"){
			$url = "http://127.0.0.1/apipro/teachers/read.php";
			$json = file_get_contents($url);
			$contents = json_decode($json,true);
			$data = $contents['records'];
			
			foreach ($data as $key => $value) {
				if($value['userid']==$_POST['user'] && $value['password']==$_POST['password']){
					$_SESSION['adminid']=$value['admin_id'];
					$_SESSION['userid'] = $value['userid'];
					header('location:teacher.php');
				}	
			}
			$msg="<span style='color:red'>Incorrect Username or Password</span>";

		}
		else{
			$url = "http://127.0.0.1/apipro/students/read.php";
			$json = file_get_contents($url);
			$contents = json_decode($json,true);
			$data = $contents['records'];
			foreach ($data as $key => $value) {
				if($value['userid']==$_POST['user'] && $value['password']==$_POST['password']){
					$_SESSION['adminid']=$value['admin_id'];
					$_SESSION['userid'] = $value['userid'];
					header('location:student.php');
				}	
			}
			$msg="<span style='color:red'>Incorrect Username or Password</span>";			
		} 	
	}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Administration</title>
    <link type="text/css" href="style.css" rel="stylesheet">
</head>
<body style="background-image: linear-gradient(90deg,#fff,#99bee6,60%,#e1b7b7);">
    <div id="Frame0">
		  <h1 align="center" color="green">Teacher's Zone</h1>
		  <h3 align="center" color="green">Connect teachers and students</h3>
	</div>
<br>
	<form action="" method="post" name="Login_Form">
	  <table width="400" border="0" align="center" cellpadding="5" cellspacing="1" class="Table">
	    <?php if(isset($msg)){?>
	    <tr>
	      <td colspan="2" align="center" valign="top"><?php echo $msg;?></td>
	    </tr>
	    <?php } ?>
	    <tr>
	      <td colspan="2" align="left" valign="top"><h3>Sign In</h3></td>
	    </tr>
	    <tr>
	      <td align="right" valign="top">Username</td>
	      <td><input name="user" type="text" class="Input" placeholder="Your Username.."></td>
	    </tr>
	    <tr>
	      <td align="right">Password</td>
	      <td><input name="password" type="password" class="Input" placeholder="Password.."></td>
	    </tr>
	    <tr>
	      <td style="float:right;">
	        <input type="radio" name="type" value="Admin" required>Admin
	      </td>
	      <td><input type="radio" name="type" style="display:inline;" value="Teacher" required>Teacher
	      	&nbsp&nbsp&nbsp&nbsp<input type="radio" name="type" style="display: inline"value="Student" required>Student</td>
	    </tr>
	    <tr>
	      <td>&nbsp;</td>
	     <td><input name="submit" type="submit" value="Login" class="Button3">
	        <a href="adminregister.php" style="padding-left:20px;"><i>Not Register Yet?</i></a>
	      </td>
	    </tr>
	  </table>
	</form>
</body>
</html>