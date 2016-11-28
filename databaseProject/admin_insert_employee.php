<?php
	if(!session_start()) {
				// If the session couldn't start, present an error
				header("Location: index.php");
				exit;
	}
	
	if (isset($_SESSION['admin'])) {
		$id = $_POST['emp_id'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$status = $_POST['status'];
		$hours = $_POST['hours'];
		$rank = $_POST['rank'];
		$job_type = $_POST['job_type'];

		include("../secure/database.php");
        $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME) or die("Connect Error" . mysqli_error($conn));
		
		if($conn -> connect_error){
			header("Locaton: index.php");
			exit;
		}
		
		$sql="INSERT INTO employee (emp_id, fname, lname, status, hours, rank, job_type) VALUES (?, ?, ?, ?, ?, ?, ?)";
		
		if($stmt = mysqli_prepare($conn, $sql)){
			mysqli_stmt_bind_param($stmt, "issbisi", $id, $fname, $lname, $status, $hours, $rank, $job_type);
			
			if(mysqli_stmt_execute($stmt)){
				log_event($conn, "CERTIFY", "Added certification {$equip} to pilot {$id}", null, null, $_SESSION['admin']);
				mysqli_close($conn);
				exit;
			}
			
			else{
				mysqli_close($conn);
				header("Location: index.php");
				exit;
			}
		}
	}
	
	else{
		//header("Location: index.php");
		exit;
	}
?>