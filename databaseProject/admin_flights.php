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
    
    include "admin_delete.php.php";
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
          <a class="navbar-brand" href="index.php"><img src="MissouriAirLogo2.jpg" style="width:100px;height:100px;"></a>
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
            Flight Number:
            <input type="text" name="num" placeholder="Flight Number">
            <br>
            Day:
            <input type="text" name="day" placeholder="Day">
			Price:
            <input type="text" name="price" placeholder="Price">
			Origin:
            <input type="text" name="origin" placeholder="Origin">
			Destination:
            <input type="text" name="dest" placeholder="Destination">
			Dep. Time:
            <input type="text" name="dep" placeholder="Departure">
			Arr. Time:
            <input type="text" name="arr" placeholder="Arrival">
			Aircraft:
            <input type="text" name="aircraft" placeholder="Aircraft">
			Pilot 1:
            <input type="text" name="pilot_1" placeholder="Pilot 1">
			Pilot 2:
            <input type="text" name="pilot_2" placeholder="Pilot 2">
			Pilot 3:
            <input type="text" name="pilot_3" placeholder="Pilot 3">
			Attendant 1:
            <input type="text" name="att_1" placeholder="Attendant 1">
			Attendant 2:
            <input type="text" name="att_2" placeholder="Attendant 2">
			Attendant 3:
            <input type="text" name="att_3" placeholder="Attendant 3">
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
        <br><br><br><br><br>
        <?php
            $sql= mysqli_prepare($conn, "SELECT * FROM flight");
                if(mysqli_stmt_execute($sql)){
                    mysqli_stmt_bind_result($sql, $number,$day,$price,$origin,$dest,$dep,$arr,$aircraft,$pilot_1,$pilot_2,$pilot_3,$att_1,$att_2,$att_3);
                    echo "<table class=\"table\">\n";
                    echo "<thead>\n\t<tr>\n\t\t<th>Number</th>\n\t\t<th>Day</th>\n\t\t<th>Price</th>\n\t\t<th>Origin</th>\n\t\t<th>Destination</th>\n\t\t<th>Departure\t\t<th>Arrival\t\t<th>Aircraft\t\t<th>Pilot 1\t\t<th>Pilot 2\t\t<th>Pilot 3\t\t<th>Attendant 1\t\t<th>Attendant 2\t\t<th>Attendant 3</th>\n</th>\n</th>\n</th>\n</th>\n</th>\n</th>\n</th>\n</th>\n</thead>\n";
                    while (mysqli_stmt_fetch($sql))
                    {
                      echo "<tr>\n";
                      echo "\t<td>" . $number . "</td>\n";
                      echo "\t<td>" . $day . "</td>\n";
					  echo "\t<td>" . $price . "</td>\n";
					  echo "\t<td>" . $origin . "</td>\n";
					  echo "\t<td>" . $dest . "</td>\n";
					  echo "\t<td>" . $dep . "</td>\n";
					  echo "\t<td>" . $arr . "</td>\n";
					  echo "\t<td>" . $aircraft . "</td>\n";
					  echo "\t<td>" . $pilot_1 . "</td>\n";
					  echo "\t<td>" . $pilot_2 . "</td>\n";
					  echo "\t<td>" . $pilot_3 . "</td>\n";
					  echo "\t<td>" . $att_1 . "</td>\n";
					  echo "\t<td>" . $att_2 . "</td>\n";
					  echo "\t<td>" . $att_3 . "</td>\n";
                      echo "\t<td><form action=\"admin_flights_edit.php\"><button name=\"Edit\" type=\"submit\" class=\"btn btn-secondary\">Edit</button></form></td>\n";
                      echo "\t<td><form action='' method='POST'><button name=\"delete\" type=\"submit\" class=\"btn btn-secondary\">Delete</button></form></td>\n";
                      echo "</tr>\n";

                }
                echo "</table>\n";
                    
                    if(isset($_POST['delete'])){
                        $table= "flight";
                        $column= "number";
                        $value= $num;
                        if(delete($table, $column, $value)==1)
                        {
                            echo "<script>alert(Sucess)</script>";
                        }
                        else
                        {
                            echo "<script>alert(Failed)</script>";
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