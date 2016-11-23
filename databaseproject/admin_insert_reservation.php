<?php
	if(!session_start()) {
				// If the session couldn't start, present an error
				header("Location: error.php");
				exit;
	}
	
	if ($admin) {
		$id = $_POST['id'];
		$flight = $_POST['flight'];
		$customer = $_POST['customer'];
		$price = $_POST['price'];

		$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		
		if($mysqli -> connect_error){
			header("Locaton: error.php");
			exit;
		}
		
		$id = $mysqli->real_escape_string($id); 
		$flight = $mysqli->real_escape_string($flight);
		$customer = $mysqli->real_escape_string($customer);
		$price = $mysqli->real_escape_string($price);
		
		$sql="INSERT INTO reservation (id, flight, customer, price) VALUES (?, ?, ?, ?)";
		
		if($stmt = mysqli_prepare($mysqli, $sql)){
			mysqli_stmt_bind_param($stmt, "ssss", $id, $flight, $customer, $price);
			
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