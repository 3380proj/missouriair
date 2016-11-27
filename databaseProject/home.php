<?php
    session_start();
    //if session is not set this will redirect to login page
    if(!isset($_SESSION['employee']) ) {
      header("Location: index.php");
      exit;
    }
    
    include("../secure/database.php");
    $conn = mysqli_connect(HOST,USERNAME,PASSWORD,DBNAME) or die("Connect Error " . mysqli_error($conn));

    $stmt = mysqli_prepare($conn, "SELECT emp_id, fname, lname, job_type, rank FROM employee WHERE emp_id LIKE ?");    
    if ($stmt) {   
        $empID = $_SESSION['employee'];
        mysqli_stmt_bind_param($stmt, "i", $empID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $num = mysqli_num_rows($result);
                
        //Row was found (data was valid) = success
        if ($num == 1){

            $row = mysqli_fetch_array($result);
            $fname = $row['fname']; 
            $lname = $row['lname'];
            $jobtype = $row['job_type'];
            $rank = $row['rank'];
            if ($jobtype == 0){
                
                $empPosition = "Admin";
                //header ("Location: admin.php");
                
                
            }else if ($jobtype == 1){
                
                $empPosition = "Pilot";
                
            }else {
                
                $empPosition = "Flight Attendant";
                
            }

        }else{

            unset($_SESSION['employee']);
            header("Location: index.php");
            
        }
    }

    if (isset($_POST['logoutBtn'])) {
        unset($_SESSION['user']);
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Missouri Air</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <style>
        
        div img {
            height: 300px; 
            width: 600px;
            display: block;
            margin: auto; 
        }
      
    </style>
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
            <p class="navbar-text navbar-right"><?php echo "Welcome " . $fname . " " . $lname;  ?></p>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>
    
    <br><br><br><br><br><br>
    <div class="container">
        <h1><?php echo $empPosition; ?></h1>
        <?php
            $statement = mysqli_prepare($conn, "SELECT * FROM flight WHERE CONCAT(pilot_1, ' ', pilot_2, ' ', pilot_3, ' ', att_1, ' ', att_2, ' ', att_3) LIKE ?");
            mysqli_stmt_bind_param($statement, "i", $empID);
            if(mysqli_stmt_execute($statement)){
                mysqli_stmt_bind_result($statement,$number,$departureDate,$price,$origin,$dest,$dep,$arr,$aircraft,$pilot_1,$pilot_2,$pilot_3,$att_1,$att_2,$att_3);
                echo "<table class=\"table\">\n";
                echo "<thead>\n\t<tr>\n\t\t<th>Origin</th>\n\t\t<th>Destination</th>\n\t\t<th>Date</th>\n\t\t<th>Departure</th>\n\t\t<th>Aircraft</th>\n\t</tr>\n</thead>\n";
                while (mysqli_stmt_fetch($statement))
                {
                  echo "<tr>\n";
                  echo "\t<td>" . $origin . "</td>\n";
                  echo "\t<td>" . $dest . "</td>\n";
                  echo "\t<td>" . $departureDate . "</td>\n";
                  echo "\t<td>" . $dep . "</td>\n";
                  echo "\t<td>" . $aircraft . "</td>\n"; 
                  echo "</tr>\n";

                }
                echo "</table>\n";
            }
            mysqli_stmt_close($statement);
        ?>
        <hr>
        <footer>
            <p>&copy; 2016 Missouri Air, Inc.</p>
        </footer>
    </div> <!-- /container -->  
      
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>