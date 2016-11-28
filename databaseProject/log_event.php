<?php
    function log_event($action_type, $action_desc) {
        $log_statement = mysqli_prepare($conn, "INSERT INTO logging (ip, action_date, action_time, action_type, action_desc, user_emp, user_cust, flight_num) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($res_statement, "sssiii", $ip, $date, $time, $action_type, $action_desc, $user_emp, $user_cust, $flight_num);

        $ip = $_SERVER['REMOTE_ADDR'];
        $date = date("Y-m-d");
        $time = date("H:i");
        $user_emp = isset($_SESSION['admin'])?$_SESSION['admin']:null;
        $user_cust = isset($cust_id)?$cust_id:null;
        $flight_num = isset($flight_no)?$flight_no:null;
    }       
?>