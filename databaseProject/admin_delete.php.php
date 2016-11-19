<?php
	if(!session_start()) {
			header("Location: error.php");
			exit;
		}
	if ($admin) {		
		$table = $_POST['tableName'];
		$column = $_POST['primaryKey'];
		$value = $_POST['primaryKeyValue'];

		$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
		
		if($mysqli -> connect_error){
			header("Locaton: error.php");
			exit;
		}
		
		$table = $mysqli->real_escape_string($table); 
		$column = $mysqli->real_escape_string($column);
		$value = $mysqli->real_escape_string($value);
		
		$pre_check = "SELECT * FROM '$table'";
		
		$pre_stmt = mysqli_prepare($mysqli, pre_check);
		
		$pre_check_result = $mysqli->query($pre_check);
		
		if($pre_check_result){
			$pre_count = $pre_check_result -> num_rows;
				
			$sql = "DELETE FROM '$table' WHERE '$column' = '$value'";
		
			$sql_stmt = mysqli_prepare($mysqli, $sql);
				
			$sqlResult = $mysqli->query($sql);
		}
		
		else{
				header("Location: error.php");
				exit;
		}
			
		if($sqlResult){
			$post_count = $sqlResult -> num_rows;
			
			if($post_count == ($pre_count - 1)){
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