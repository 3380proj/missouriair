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
        <h3>Flight Lookup</h3>
        <form action="lookup.php" method="POST">
          <!-- if we decide to use Amount of Logs#####
            Amount of Logs
            <select name="amountOfLogs">
                <option selected disabled>Choose here</option>
                <option value = "25">25</option>
                <option value = "50">50</option>
                <option value = "100">100</option>
                <option value = "200">200</option>
                <option value = "500">500</option>
            </select> -->
            IP:
            <input type="text" name="cust_id">
            <br><br>
            
            <input type="submit" name="submit" value="Submit" class="btn btn-success">
            <br>
            <br>
        </form>
        <!--
        What else do we want to search by? PHP up top for session might need to be added/changed

        -->
        <?php 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include("../secure/database.php");
        $conn = mysqli_connect(HOST,USERNAME,PASSWORD,DBNAME) or die("Connect Error " . mysqli_error($conn));
        
        $cust_id=$_POST["cust_id"];

        $statement = mysqli_prepare($conn, "SELECT reservation.flight, reservation.price, flight.day, flight.origin, flight.dest, flight.dep, flight.aircraft FROM reservation INNER JOIN flight ON reservation.flight = flight.number WHERE reservation.customer = ?");
        mysqli_stmt_bind_param($statement, "i", $cust_id);
        if(mysqli_stmt_execute($statement)){
            $result = mysqli_stmt_get_result($statement);
            echo "<table class=\"table\">\n";
            echo "<thead>\n\t<tr>\n\t\t<th>Flight Number</th>\n\t\t<th>Price</th>\n\t\t<th>Date</th>\n\t\t<th>Origin</th>\n\t\t<th>Destination</th>\n\t\t<th>Departure</th>\n\t\t<th>Aircraft</th>\n\t</tr>\n</thead>\n";
           
            while ($row = $result->fetch_assoc())
            {
              echo "<tr>\n";
              echo "\t<td>" . $row['flight'] . "</td>\n";
              echo "\t<td>" . $row['price'] . "</td>\n";
              echo "\t<td>" . $row['day'] . "</td>\n";
              echo "\t<td>" . $row['origin'] . "</td>\n";
              echo "\t<td>" . $row['dest'] . "</td>\n"; 
              echo "\t<td>" . $row['dep'] . "</td>\n";
              echo "\t<td>" . $row['aircraft'] . "</td>\n";    

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
