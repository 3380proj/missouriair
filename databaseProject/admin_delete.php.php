<?php
    function delete($table, $column, $value){
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