<?php
    function delete($table, $value){
        include("log_event.php");
        if (isset($_SESSION['admin'])) {
            $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME) or die("Connect Error" . mysqli_error($conn));

            if($conn -> connect_error){
                header("Locaton: index.php");
                exit;
            }

                switch ($table) {
                    case "certification":
                        $stmt = mysqli_prepare($conn, "DELETE FROM certification WHERE emp_id = ?");
                        mysqli_stmt_bind_param($stmt, "i", $value);
                        log_event($conn, "CERTIFY", "Removed certification from pilot {$value}", null, null, $_SESSION['admin']);
                        break;
                        
                    case "customer":
                        $stmt = mysqli_prepare($conn, "DELETE FROM customer WHERE id = ?");
                        mysqli_stmt_bind_param($stmt, "i", $value);
                        log_event($conn, "CUSTOMER", "Removed customer {$value}", null, null, $_SESSION['admin']);
                        break;
                        
                    case "employee":
                        $stmt = mysqli_prepare($conn, "DELETE FROM employee WHERE emp_id = ?");
                        mysqli_stmt_bind_param($stmt, "i", $value);
                        log_event($conn, "TERMINATE", "Terminated employee {$value}", null, null, $_SESSION['admin']);
                        break;
                        
                    case "equipment":
                        $stmt = mysqli_prepare($conn, "DELETE FROM equipment WHERE serial LIKE ?");
                        mysqli_stmt_bind_param($stmt, "s", $value);
                        log_event($conn, "EQUIP", "Removed equipment {$value}", null, null, $_SESSION['admin']);
                        break;  
                        
                    case "flight":
                        $stmt = mysqli_prepare($conn, "DELETE FROM flight WHERE number = ?");
                        mysqli_stmt_bind_param($stmt, "i", $value);
                        log_event($conn, "FLIGHT", "Cancelled flight {$value}", null, null, $_SESSION['admin']);
                        break;
         
                }
                if(mysqli_stmt_execute($stmt)){
                    return 1;
                }else{
                    return 0;
                }
            }

        else{
            header("Location: index.php");
            exit;
        }
    }
?>