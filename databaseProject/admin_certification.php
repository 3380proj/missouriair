<?php

    session_start();
    //if session is not set this will redirect to login page
    if(!isset($_SESSION['admin'])) {
      header("Location: index.php");
      exit;
    }

    if (isset($_POST['logoutBtn'])) {
        unset($_SESSION['admin']);
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit;
    }
    
    include("../secure/database.php");
    $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DBNAME) or die("Connect Error" . mysqli_error($conn));
    include "admin_insert_certification.php";
    include "admin_delete.php";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Administrator Page</title>

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
    
    <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Admin Page</title>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="jumbotron.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
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
          <a class="navbar-brand" href="#"><img src="MissouriAirLogo2.jpg" style="width:100px;height:100px;"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <form class="navbar-form navbar-right" method = "POST">
                <button type="submit" name="logoutBtn" class="btn btn-danger navbar-right">Logout</button>
            </form>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <br><br><br><br><br><br>
    <div class="container"> <!--Container-->

        <form method="POST" action="admin_insert_certification.php" name="new_certification">
            Employee ID:
            <input type="text" name="emp_id" placeholder="Employee ID">
            <br>
            Equipment:
            <input type="text" name="equipment" placeholder="Equipment">
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
        <br><br><br><br><br>
        <?php
            $sql= mysqli_prepare($conn, "SELECT * FROM certification");
                if(mysqli_stmt_execute($sql)){
                    mysqli_stmt_bind_result($sql,$emp_id,$equipment);
                    echo "<table class=\"table\">\n";
                    echo "<thead>\n\t<tr>\n\t\t<th>Employee ID</th>\n\t\t<th>Equipment</th>\n</thead>\n";
                    while (mysqli_stmt_fetch($sql))
                    {
                      echo "<tr>\n";
                      echo "\t<td>" . $emp_id . "</td>\n";
                      echo "\t<td>" . $equipment . "</td>\n";
                      echo "\t<td><form action=\"admin_certification_edit.php\"><button name=\"Edit\" type=\"submit\" value=\"{$number}\" class=\"btn btn-secondary\">Edit</button></form></td>\n";
                      echo "\t<td><form action="" method="POST"><button name=\"delete\" type=\"submit\" value=\"{$number}\" class=\"btn btn-secondary\">Delete</button></form></td>\n";
                      echo "</tr>\n";

                }
                echo "</table>\n";
                    
                    if($_POST["delete"]){
                        $table= "certification";
                        $column= "emp_id";
                        $value= $emp_id;
                        if(delete($table, $column, $value)==1)
                        {
                            echo "<script>alert(Sucess)</script>";
                        }
                        else
                        {
                            echo "<script>alert(Failed)</script>"
                        }
                        
                    }
            }
            mysqli_stmt_close($sql);
            mysqli_close($conn);       
            
        ?>
    </div> <!-- /container -->

      
      
      

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>