<?php
	session_start();
	if(isset($_POST['submit'])){
		include('./Requests/library/Requests.php');
		Requests::register_autoloader();

		$name= $_POST['name'];		
		$userid= $_POST['userid'];
		$password = $_POST['password'];
		$confirm = $_POST['confirm'];
		$institute = $_POST['institution'];
		$contact_no = $_POST['contact'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		if($password != $confirm){
			$msg="<span style='color:red'>Password Not Matched</span>";
		}
		else{
			$data = array('userid' => $userid, 'password' => $password, 'email' => $email, 'institute' => $institute,'name' => $name,'contact_no' => $contact_no, 'address' => $address);		
			
			$_SESSION['userid']=$userid;
			$response = Requests::post('http://127.0.0.1/apipro/admins/create.php', array(), $data);
			var_dump($response->body);
			header('location:admin.php');
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<link type="text/css" href="style.css" rel="stylesheet">
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
	<div id="Frame0">
		<h1 align="center" color="green">Admin Regisration</h1>	
	</div>
	</br>
	<div id="Frame0">
		<form action="" method="post" name="register_form">
			<label>Full Name<font style="color:red;">*</font></label>
			<input type="text" name="name" id="name" placeholder="Enter Your Full Name..." required>
			<label>User Name<font style="color:red;">*</font></label>
			<input type="text" name="userid" id="userid" placeholder="Enter Your User Name..." required>
			<label>Password<font style="color:red;">*</font></label>
			<input type="password" name="password" id="password" placeholder="Enter a Password..." required>
			<label>Confirm Password<font style="color:red;">*</font></label>
			<?php if(isset($msg)){
				echo  $msg ;	
			} 
			?>
			<input type="password" name="confirm" id="confirm" placeholder="Enter a Password Same as before..." required>

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