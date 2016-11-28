<?php
	if(!session_start()) {
				// If the session couldn't start, present an error
				header("Location: error.php");
				exit;
	}
	
	if (isset($_SESSION['admin'])) {
		$number = $_POST['number'];
		$aircraft = $_POST['aircraft'];
		$pilot_1 = $_POST['pilot'];
		$pilot_2 = $_POST['pilot_2'];
		$pilot_3 = $_POST['pilot_3'];
		$att_1 = $_POST['att_1'];
		$att_2 = $_POST['att_2'];
		$att_3 = $_POST['att_3'];
		$origin = $_POST['origin'];
		$dest = $_POST['dest'];
		$day = $_POST['day'];
		$dep = $_POST['dep'];
		$arr = $_POST['arr'];
		$price = $_POST['price'];

		include("../secure/database.php");
        $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME) or die("Connect Error" . mysqli_error($conn));
		
		if($conn -> connect_error){
			header("Locaton: index.php");
			exit;
		}
		
		$sql="INSERT INTO flight (number, aircraft, pilot_1, pilot_2, pilot_3, att_1, att_2, att_3, origin, dest, day, dep, arr, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		
		if($stmt = mysqli_prepare($conn, $sql)){
			mysqli_stmt_bind_param($stmt, "isiiiiiisssssd", $number, $aircraft, $pilot_1, $pilot_2, $pilot_3, $att_1, $att_2, $att_3, $origin, $dest, $day, $dep, $arr, $price);
			
			if(mysqli_stmt_execute($stmt)){
              	include("log_event.php");
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
		header("Location: index.php");
		exit;
	}
?>