<?php
	if(!session_start()) {
				// If the session couldn't start, present an error
				header("Location: error.php");
				exit;
	}
	
	if ($admin) {
		$equiptment = $_POST['equiptment'];
		$description = $_POST['description'];
		$serial = $_POST['serial'];
		$seat = $_POST['seat'];
		$pilots = $_POST['pilots'];
		$att = $_POST['att'];

		$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		
		if($mysqli -> connect_error){
			header("Locaton: error.php");
			exit;
		}
		
		$equiptment = $mysqli->real_escape_string($equiptment); 
		$description = $mysqli->real_escape_string($description);
		$serial = $mysqli->real_escape_string($serial);
		$seat = $mysqli->real_escape_string($seat); 
		$pilots = $mysqli->real_escape_string($pilots);
		$att = $mysqli->real_escape_string($att);
		
		$sql="INSERT INTO equiptment (equiptment, description, serial, seat, pilots, att) VALUES (?, ?, ?, ?, ?, ?)";
		
		if($stmt = mysqli_prepare($mysqli, $sql)){
			mysqli_stmt_bind_param($stmt, "ssssss", $equiptment, $description, $serial, $seat, $pilots, $att);
			
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