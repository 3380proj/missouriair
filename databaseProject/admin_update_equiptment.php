<?php
	if(!session_start()) {
				// If the session couldn't start, present an error
				header("Location: error.php");
				exit;
	}
	
	if ($admin) {
		$equipment = $_POST['equipment'];
		$serial = $_POST['serial'];
		$seat = $_POST['seat'];
		$pilots = $_POST['pilots'];
		$att = $_POST['att'];

		$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		
		if($mysqli -> connect_error){
			header("Locaton: error.php");
			exit;
		}
		
		$equipment = $mysqli->real_escape_string($equipment);
		$serial = $mysqli->real_escape_string($serial);
		$seat = $mysqli->real_escape_string($seat); 
		$pilots = $mysqli->real_escape_string($pilots);
		$att = $mysqli->real_escape_string($att);
		
		$sql="UPDATE equipment SET equipment = '$equipment', seat = '$seat', pilots = '$pilots', att = '$att' WHERE serial = '$serial'";
		
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