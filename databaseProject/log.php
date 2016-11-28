<?php

    //session_start();
    // if session is not set this will redirect to home page
    //if( !isset($_SESSION['user']) ) {
      //header("Location: index.php");
      //exit;
    //}
    
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
          <a class="navbar-brand" href="home.php"><img src="MissouriAirLogo2.jpg" style="width:100px;height:100px;"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <form class="navbar-form navbar-right">
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>
    
    <br><br><br><br><br><br>
    <div class="container">
        <h3>Logs</h3>
        <form action="log.php" method="POST">
            Amount of Logs
            <select name="amountOfLogs">
                <option selected disabled>Choose here</option>
                <option value = "25">25</option>
                <option value = "50">50</option>
                <option value = "100">100</option>
                <option value = "200">200</option>
                <option value = "500">500</option>
            </select>
            Start Date:
            <input type ="time" name="start_date" id="start_date">
            End Date:
            <input type ="time" name="end_date" id="end_date">
            Type of Action:
            <select name="action">
                <option value = "reservation">Reservation</option>
                <option value = "flight">Flight</option>
            </select>
            <br>
            <input type="submit" name="refreshBtn" value="Refresh" class="btn btn-success">
            <br>
            <br>
        </form>
        <!--
        HOW DO YOU SEARCH BY amountOfLogs?

        -->
        <?php 
         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include("../secure/database.php");
        $conn = mysqli_connect(HOST,USERNAME,PASSWORD,DBNAME) or die("Connect Error " . mysqli_error($conn));
        
        $origin_search = "%{$_POST['origin']}%";
        $dest_search = "%{$_POST['dest']}%";
        $departureDate_search = "%{$_POST['departureDate']}%";
        $price_search = "%{$_POST['price']}%"; 
        $statement = mysqli_prepare($conn, "SELECT * FROM logging WHERE origin LIKE ? AND dest LIKE ? AND action_TIME LIKE ? AND action LIKE ?");
        mysqli_stmt_bind_param($statement, "ssss", $origin_search, $dest_search, $departureDate_search, $price_search);
        if(mysqli_stmt_execute($statement)){
            mysqli_stmt_bind_result($statement,$number,$departureDate,$price,$origin,$dest,$dep,$arr,$aircraft,$pilot_1,$pilot_2,$pilot_3,$att_1,$att_2,$att_3);
            echo "<table class=\"table\">\n";
            echo "<thead>\n\t<tr>\n\t\t<th>Origin</th>\n\t\t<th>Destination</th>\n\t\t<th>Date</th>\n\t\t<th>Departure</th>\n\t\t<th>Price</th>\n\t</tr>\n</thead>\n";
            while (mysqli_stmt_fetch($statement))
            {
              echo "<tr>\n";
              echo "\t<td>" . $origin . "</td>\n";
              echo "\t<td>" . $dest . "</td>\n";
              echo "\t<td>" . $departureDate . "</td>\n";
              echo "\t<td>" . $dep . "</td>\n";
              echo "\t<td>" . $price . "</td>\n"; 
              echo "\t<td><form action=\"confirmRes.php\"><button name=\"resSelect\" type=\"submit\" value=\"{$number}\" class=\"btn btn-secondary\">Reserve</button></form></td>\n";
              echo "</tr>\n";
              
            }
            echo "</table>\n";
        }
        mysqli_stmt_close($statement);
        mysqli_close($conn);
      	}
        
        
        ?>
        
        <!-- This part is currently commented out because I dont know if it needs to be deleted yet
        echo "<table class=\"table\">\n";
            echo "<thead>\n\t<tr>\n\t\t<th>Log_Num</th>\n\t\t<th>IP</th>\n\t\t<th>Action Time</th>\n\t\t<th>Action</th>\n\t\t<th>User_Emp</th>\n\t\t<th>User_Cust</th>\n\t\t<th>Flight_Num</th></tr>\n</thead>\n";
        ?> -->
    </div> <!-- /container -->  
      
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
