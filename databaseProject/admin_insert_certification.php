<?php
	if(!session_start()) {
				// If the session couldn't start, present an error
				header("Location: error.php");
				exit;
	}
	
	if ($admin) {
		$id = $_POST['id'];
		$equip = $_POST['equip'];

		$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		
		if($mysqli -> connect_error){
			header("Locaton: error.php");
			exit;
		}
		
		$id = $mysqli->real_escape_string($id); 
		$equip = $mysqli->real_escape_string($equip);
		
		$sql="INSERT INTO certification (emp_id, equipment) VALUES (?, ?)";
		
		if($stmt = mysqli_prepare($mysqli, $sql)){
			mysqli_stmt_bind_param($stmt, "ss", $id, $equip);
			
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