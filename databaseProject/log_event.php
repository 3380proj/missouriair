<?php
    function log_event($conn, $action_type, $action_desc, $flight_no, $user_cust, $user_emp) {
        $log_statement = mysqli_prepare($conn, "INSERT INTO logging (ip, action_date, action_time, action_type, action_desc, user_emp, user_cust, flight_num) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($log_statement, "sssssiii", $ip, $date, $time, $action_type, $action_desc, $user_emp, $user_cust, $flight_no);

        $ip = $_SERVER['REMOTE_ADDR'];
        $date = date("Y-m-d");
        $time = date("H:i");

        mysqli_stmt_execute($log_statement);
    }       
?>