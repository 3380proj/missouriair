<?php
//Login
include_once 'dbconfig.php';

if(!session_start()) {
    // If the session couldn't start, present an error
    header("Location: error.php");
    exit;
}

if (isset($_POST['loginBtn'])){


    $loggedIn = empty($_SESSION['user_session']) ? false : $_SESSION['user_session'];

    if ($loggedIn){
        exit;
    }

    $username = trim($_POST['username']);
    $username = strip_tags($username);
    $username = htmlspecialchars($username);

    $password = trim($_POST['password']);
    $password = strip_tags($pass);
    $password = htmlspecialchars($pass);


    if(empty($username)){

        $error = true;
        $usernameError = "Please enter valid username";

    }
    if(empty($password)){

        $error = true;
        $passwordError = "Please enter valid password";
    }


    if (!$error) {
        $stmt = mysqli_prepare($conn, "SELECT user_id, pass_hash, permissions FROM authentication WHERE user_id = ? AND pass_hash = ?");

        if ($stmt) {

            mysqli_stmt_bind_param($stmt, "ss", $username, $password);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_fetch($stmt)) {

                $row = mysqli_fetch_array($res);
                if ($row['permissions'] == 1){

                    $_SESSION['admin'] = $row['userId'];
                    header(index.html);


                }else {

                    $_SESSION['user'] = $row['userId'];
                    header(index.html);
                }
            } else {

                $errorMessage = "Invalid username/password combination";

            }
        }
        mysqli_stmt_close($stmt);
    }
}
?>