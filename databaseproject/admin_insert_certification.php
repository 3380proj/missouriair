<?php
	if(!session_start()) {
				// If the session couldn't start, present an error
				header("Location: error.php");
				exit;
	}
	
	if (isset($_SESSION['admin'])) {
		$id = $_POST['emp_id'];
		$equip = $_POST['equipment'];

		include("../secure/database.php");
        $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME) or die("Connect Error" . mysqli_error($conn));
		
		if($conn -> connect_error){
			header("Locaton: error.php");
			exit;
		}
		
		$id = $conn->real_escape_string($id); 
		$equip = $conn->real_escape_string($equip);
		
		$sql="INSERT INTO certification (emp_id, equipment) VALUES (?, ?)";
		
		if($stmt = mysqli_prepare($conn, $sql)){
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