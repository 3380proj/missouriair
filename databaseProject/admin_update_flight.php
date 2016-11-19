<?php
	if(!session_start()) {
				// If the session couldn't start, present an error
				header("Location: error.php");
				exit;
	}
	
	if ($admin) {
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

		$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		
		if($mysqli -> connect_error){
			header("Locaton: error.php");
			exit;
		}
		
		$number = $mysqli->real_escape_string($number); 
		$aircraft = $mysqli->real_escape_string($aircraft);
		$pilot_1 = $mysqli->real_escape_string($pilot_1);
		$pilot_2 = $mysqli->real_escape_string($pilot_2); 
		$pilot_3 = $mysqli->real_escape_string($pilot_3);
		$att_1 = $mysqli->real_escape_string($att_1);
		$att_2 = $mysqli->real_escape_string($att_2);
		$att_3 = $mysqli->real_escape_string($att_3);
		$origin = $mysqli->real_escape_string($origin);
		$dest = $mysqli->real_escape_string($dest);
		$day = $mysqli->real_escape_string($day);
		$dep = $mysqli->real_escape_string($dep);
		$arr = $mysqli->real_escape_string($arr);
		$price = $mysqli->real_escape_string($price);
		
		$sql="UPDATE flight SET aircraft = '$aircraft', pilot_1 = '$pilot_1', pilot_2 = '$pilot_2', pilot_3 = '$pilot_3', att_1 = '$att_1', att_2 = '$att_2', att_3 = '$att_3', origin = '$origin', dest = '$dest', day = '$day', dep = '$dep', arr = '$arr', price = '$price' WHERE flight_no = '$number'";
		
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