<?php

	$host = "localhost";
	$username="root";
	$pwd="";
	$db="api"


    $upload_path = 'image/';
    $server_ip = gethostbyname(gethostname());
    $upload_url = 'http://'.$server_ip.'/'.$upload_path;
    $response = array();

    if($_SERVER['REQUEST_METHOD']=='POST'){

    	if(isset($_POST['name']) and isset($_POST['email']) and isset($_FILES['image']['name']))
    	{

    		$con = mysqli_connect($host,$username,$pwd,$db);

    		if(mysqli_connect_error($con)){
    			echo "Failed To Connect";
    		}

    		$name = $_POST['name'];
    		$email = $_POST['email'];
    		$fileinfo = pathinfo($_FILES['image']['name']);
    		$extension = $fileinfo['extension'];
    		$file_url = $upload_url.'IMG_'.$name.'.'.$extension;
    		$file_path = $upload_path. 'IMG_'.$name.'.'.$extension;

    		try{

    			move_uploaded_file($_FILES['image']['tmp_name'], $file_path);
    			$sql = "INSERT INTO `profile`()"
    		}
    		catch(Exception $e)
    		{

    		}

    	}
    }

?>