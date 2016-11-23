<?php
	if(!session_start()) {
				// If the session couldn't start, present an error
				header("Location: error.php");
				exit;
	}
	
	if ($admin) {
		$id = $_POST['id'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$status = $_POST['status'];
		$hours = $_POST['hours'];
		$rank = $_POST['rank'];
		$job_type = $_POST['job_type'];

		$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		
		if($mysqli -> connect_error){
			header("Locaton: error.php");
			exit;
		}
		
		$id = $mysqli->real_escape_string($id); 
		$fname = $mysqli->real_escape_string($fname);
		$lname = $mysqli->real_escape_string($lname);
		$status = $mysqli->real_escape_string($status); 
		$hours = $mysqli->real_escape_string($hours);
		$rank = $mysqli->real_escape_string($rank);
		$job_type = $mysqli->real_escape_string($job_type);
		
		$sql="UPDATE employee SET fname = '$fname', lname = '$lname', status = '$status', hours = '$hours', rank = '$rank', job_type = '$job_type') WHERE emp_id = '$id'";
		
		if($stmt = mysqli_prepare($mysqli, $sql)){
			if(mysqli_stmt_execute($stmt)){
				exit;
			}
			
			else{
				header("Location: error.php");
				exit;
			}
		}
	}
	
	else{
		header("Location: index.php");
		exit;
	}
?>