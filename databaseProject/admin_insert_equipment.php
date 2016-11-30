<?php
	if(!session_start()) {
				// If the session couldn't start, present an error
				header("Location: error.php");
				exit;
	}
	
	if ($_SESSION['admin'])) {
		$equipment = $_POST['equipment'];
		$serial = $_POST['serial'];
		$seat = $_POST['seat'];
		$pilots = $_POST['pilot'];
		$att = $_POST['att'];

		include("../secure/database.php");
        $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME) or die("Connect Error" . mysqli_error($conn));
		
		if($conn -> connect_error){
			header("Locaton: index.php");
			exit;
		}
		
		$sql="INSERT INTO equipment (equipment, serial, seat, pilots, att) VALUES ( ?, ?, ?, ?, ?)";
		
		if($stmt = mysqli_prepare($conn, $sql)){
			mysqli_stmt_bind_param($stmt, "ssiii", $equipment, $serial, $seat, $pilots, $att);
			
			if(mysqli_stmt_execute($stmt)){
				include("log_event.php");
				log_event($conn, "EQUIP", "Added equipment {$equip}-{$serial}", null, null, $_SESSION['admin']);
				mysqli_close($conn);
				exit;
			}
			
			else{
				mysqli_close($conn);
				header("Location: error.php");
				exit;
			}
		}
	}
	
	else{
		//header("Location: index.php");
		exit;
	}
?>