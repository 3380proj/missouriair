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
		$equiptment = $_POST['equiptment'];

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
		$equiptment = $mysqli->real_escape_string($equiptment);
		
		$sql="INSERT INTO employee (emp_id, fname, lname, status, hours, rank, equiptment) VALUES (?, ?, ?, ?, ?, ?, ?)";
		
		if($stmt = mysqli_prepare($mysqli, $sql)){
			mysqli_stmt_bind_param($stmt, "sssssss", $id, $fname, $lname, $status, $hours, $rank, $equiptment);
			
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