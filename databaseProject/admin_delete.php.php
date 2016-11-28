<?php
    function delete($table, $column, $value){
        if(!session_start()) {
                header("Location: index.php");
                exit;
            }
        if ($admin) {		
            include("../secure/database.php");
            $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME) or die("Connect Error" . mysqli_error($conn));

            if($conn -> connect_error){
                header("Locaton: index.php");
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
                    header("Location: index.php");
                    exit;
            }

            if($sqlResult){
                $post_count = $sqlResult -> num_rows;

                if($post_count == ($pre_count - 1)){
                    return 1;
                    exit;
                }

                else{
                    header("Location: index.php");
                    exit;
                }
            }
        }

        else{
            header("Location: index.php");
            exit;
        }
    }
?>