<?php
    function delete($table, $value){
        if (isset($_SESSION['admin'])) {
            $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME) or die("Connect Error" . mysqli_error($conn));

            if($conn -> connect_error){
                header("Locaton: index.php");
                exit;
            }

            $pre_check = "SELECT * FROM '$table'";

            $pre_stmt = mysqli_prepare($conn, $pre_check);

            $pre_check_result = $conn->query($pre_check);

            if($pre_check_result){
                /*
                $pre_count = $pre_check_result -> num_rows;

                $sql = "DELETE FROM '$table' WHERE '$column' = '$value'";

                $sql_stmt = mysqli_prepare($mysqli, $sql);

                $sqlResult = $mysqli->query($sql);
                */
                
                switch ($table) {
                    case "certification":
                        $stmt = mysqli_prepare($conn, "DELETE FROM certification WHERE emp_id = ?");
                        mysqli_stmt_bind_param($stmt, "i", $value);
                        break;
                        
                    case "customer":
                        $stmt = mysqli_prepare($conn, "DELETE FROM customer WHERE id = ?");
                        mysqli_stmt_bind_param($stmt, "i", $value);
                        break;
                        
                    case "employee":
                        $stmt = mysqli_prepare($conn, "SELECT * FROM employee WHERE emp_id = ?");
                        mysqli_stmt_bind_param($stmt, "i", $value);
                        break;
                        
                    case "equipment":
                        $stmt = mysqli_prepare($conn, "SELECT * FROM equipment WHERE serial LIKE ?");
                        mysqli_stmt_bind_param($stmt, "s", $value);
                        break;  
                        
                    case "flight":
                        $stmt = mysqli_prepare($conn, "SELECT * FROM flight WHERE number = ?");
                        mysqli_stmt_bind_param($stmt, "i", $value);
                        break;
         
                }
                if(mysqli_stmt_execute($stmt)){
                    return 1;
                }else{
                    return 0;
                }
                
            else{
                exit();
            }
        }

        else{
            header("Location: index.php");
            exit;
        }
    }
?>