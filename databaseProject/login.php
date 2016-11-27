<?php
    session_start();
    $error = false;
    $usernameError = "";
    $passwordError = "";
    $message = "";
    
    if (isset($_POST['loginBtn'])){
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include("../secure/database.php");
            $conn = mysqli_connect(HOST,USERNAME,PASSWORD,DBNAME) or die("Connect Error " . mysqli_error($conn));
        }
        
        //Clean inputs
        $username = trim($_POST['username']);
        $username = strip_tags($username);
        $username = htmlspecialchars($username);
        $username = mysqli_real_escape_string($conn, $username);

        $password = trim($_POST['password']);
        $password = strip_tags($password);
        $password = htmlspecialchars($password);
        $password = mysqli_real_escape_string($conn, $password);

        //name validation
        if(empty($username)){

            $error = true;
            $usernameError = "Please enter valid username";

        }
        
        //password validation
        if(empty($password)){

            $error = true;
            $passwordError = "Please enter valid password";
        }

        //if there's no error, continue to login
        if (!$error) {
            $stmt = mysqli_prepare($conn, "SELECT user_name, pass_hash FROM authentication WHERE user_name LIKE ? AND pass_hash LIKE ?");
            
            if ($stmt) {    
                mysqli_stmt_bind_param($stmt, "ss", $username, $password);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $num = mysqli_num_rows($result);
                
                //Row was found (data was valid) = success
                if ($num == 1){
                    
                    $row = mysqli_fetch_array($result);
                    $user = $row['user_id']; 
                    $_SESSION['employee'] = $user;
                    header("Location: home.php");
                    
                }else{
                    
                    $message = "Invalid Username or Password.";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html>

    <head>
    
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Login</title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    
    </head>

    <body>
    
        <nav class="navbar navbar-inverse navbar-fixed-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php"><img src="MissouriAirLogo2.jpg" style="width:100px;height:100px;"></a>
            </div>
          </div>
        </nav>
        
        <br><br><br><br><br><br>
        <div class="container">
            <form method="post">
                <h3>Employee Login</h3>

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <input type="text" name="username" class="form-control" placeholder="Enter Name" maxlength="50"/>
                    </div>
                    <span class="text-danger"><?php echo $usernameError; ?></span>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                        <input type="password" name="password" class="form-control" placeholder="Enter Password" maxlength="15"/>
                    </div>
                    <span class="text-danger"><?php echo $passwordError; ?></span>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <button type="submit" class="btn btn-block btn-primary" name="loginBtn">Login</button>
                    </div>
                    <span class="text-danger"><?php echo $message; ?></span>
                </div>

                <div class="form-group">
                    <a href="register.php">Sign Up Here...</a>
                </div>
            
            </form>
        </div> <!-- /container -->
        
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        
    </body>
</html>