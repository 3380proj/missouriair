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

		$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		
		if($mysqli -> connect_error){
			header("Locaton: error.php");
			exit;
		}
		
		$id = $mysqli->real_escape_string($id); 
		$fname = $mysqli->real_escape_string($fname);
		$lname = $mysqli->real_escape_string($lname);
		
		$sql="UPDATE customer SET fname = '$fname', lname = '$lname') WHERE id = '$id'";
		
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