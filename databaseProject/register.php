<?php   
    session_start();
    if( isset($_SESSION['user']) ) {
      header("Location: home.php");
      exit;
    }
    if( isset($_SESSION['admin']) ) {
      header("Location: admin.php");
      exit;
    }
    $error = false;
    $usernameError = "";
    $passwordError = "";
    $idError = "";
    $message = "";

    if (isset($_POST['registerBtn'])) {
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include("../secure/database.php");
            $conn = mysqli_connect(HOST,USERNAME,PASSWORD,DBNAME) or die("Connect Error " . mysqli_error($conn));
        }
  
        // Clean inputs
        
        $empID = trim($_POST['empID']);
        $empID = strip_tags($empID);
        $empID = htmlspecialchars($empID);
        $empID = mysqli_real_escape_string($conn, $empID);
        
        $username = trim($_POST['username']);
        $username = strip_tags($username);
        $username = htmlspecialchars($username);
        $username = mysqli_real_escape_string($conn, $username);

        $password = trim($_POST['password']);
        $password = strip_tags($password);
        $password = htmlspecialchars($password);
        $password = mysqli_real_escape_string($conn, $password);

        //employee ID validation
        if (empty($empID)) {
            $error = true;
            $usernameError = "Please enter your employee ID.";
        } 
        
        $statement = mysqli_prepare($conn, "SELECT emp_id FROM employee where emp_id = ?");
        if ($statement) {
                
            mysqli_stmt_bind_param($statement, "i", $empID);
            mysqli_stmt_execute($statement);
            $result = mysqli_stmt_get_result($statement);
            $num = mysqli_num_rows($result);

            //Row was inserted (data was valid) = success
            if (!($num == 1)){

                $error = true;
                $idError = "Invalid employee ID!"; 

            }
        }
            
        //name validation
        if (empty($username)) {
            $error = true;
            $usernameError = "Please enter a username.";
            
        } else if (strlen($username) < 3) {
            $error = true;
            $usernameError = "Name must have atleat 3 characters.";
        }

        // password validation
        if (empty($password)){
            $error = true;
            $passwordError = "Please enter password.";
        } else if(strlen($password) < 6) {
            $error = true;
            $passwordError = "Password must have atleast 6 characters.";
        }
        
        // if there's no error, continue to signup
        if(!$error) {
            
            $stmt = mysqli_prepare($conn, "INSERT INTO authentication (user_id, user_name, pass_hash) VALUES (?, ?, ?)");
            if ($stmt) {
                
                mysqli_stmt_bind_param($stmt, "iss", $empID, $username, $password);
                mysqli_stmt_execute($stmt);
                $num = mysqli_affected_rows($conn);
                
                //Row was inserted (data was valid) = success
                if ($num == 1){
                    
                    $message = "Successfully registered, you may login now";
                    unset($username);
                    unset($password);
                    
                }else {
                    
                    $message = "Something went wrong, try again later..."; 
                    
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
        <title>Registration</title>
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        
        <script>
            /*
            function employeeType(nameSelect){
                console.log(nameSelect);
                if(nameSelect){
                    if(nameSelect.value == 1){
                        document.getElementById("flight-attendant-box").style.display = "block";
                        document.getElementById("pilot-box").style.display = "none";
                    }
                    else{
                        document.getElementById("pilot-box").style.display = "block";
                        document.getElementById("flight-attendant-box").style.display = "none";
                    }
                }
                else{
                    document.getElementById("flight-attendant-box").style.display = "none";
                    document.getElementById("pilot-box").style.display = "none";
                }
            }
            */
            
        </script>

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
            <form method="POST">
                <h3>Employee Registration</h3>
                
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <input type="text" name="empID" class="form-control" placeholder="Enter your employee ID" maxlength="50"/>
                    </div>
                    <span class="text-danger"><?php echo $idError; ?></span>
                </div>
                
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                        <input type="text" name="username" class="form-control" placeholder="Enter a username" maxlength="50"/>
                    </div>
                    <span class="text-danger"><?php echo $usernameError; ?></span>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                        <input type="password" name="password" class="form-control" placeholder="Enter a password" maxlength="15"/>
                    </div>
                    <span class="text-danger"><?php echo $passwordError; ?></span>
                </div>
                
                
                <!--
                <div class="form-group">
                    <div class="input-group">
                        <select onchange="employeeType(this);">
                            <option selected disabled>Choose Employee Type</option>
                            <option value="1">Flight Attendant</option>
                            <option value="2">Pilot</option>
                        </select>
                    </div>
                    <div id="flight-attendant-box" style="display:none;">
                        <input type="text" name="fname" class="form-control" placeholder="Enter First Name" maxlength="50"/>
                        <input type="text" name="lname" class="form-control" placeholder="Enter Last Name" maxlength="50"/>
                    </div>
                    <div id="pilot-box" style="display:none;">
                        <input type="text" name="fname" class="form-control" placeholder="Enter First Name" maxlength="50"/>
                        <input type="text" name="lname" class="form-control" placeholder="Enter Last Name" maxlength="50"/>
                    </div>
                </div>
                -->

                <div class="form-group">
                    <div class="input-group">
                        <button type="submit" class="btn btn-block btn-primary" name="registerBtn">Register</button>
                    </div>
                    <span class="text-danger"><?php echo $message; ?></span>
                </div>

                <div class="form-group">
                    <a href="login.php">Login here...</a>
                </div>
            
            </form>
        </div> <!-- /container -->
        
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
        
    </body>
</html>