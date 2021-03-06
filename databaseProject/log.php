<?php

    session_start();
    //if session is not set this will redirect to home page
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
          <form class="navbar-form navbar-right" method="POST">
              <button type="submit" name="logoutBtn" class="btn btn-danger navbar-right">Logout</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>
    
    <br><br><br><br><br><br>
    <div class="container">
        <h3>Logs</h3>
        <form action="log.php" method="POST">
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
            <input type="text" name="ip">
            Date:
            <input type="text" name="action_date" placeholder="yyyy-mm-dd">
            
            Type of Action:
            <select name="action_type">
                <option value = ""></option>
                <option value = "RESERVE">Reservation</option>
                <option value = "CERTIFY">Certification</option>
                <option value = "ONBOARD">Onboarding</option>
                <option value = "TERMINATE">Termination</option>
                <option value = "CUSTOMER">Customer</option>
                <option value = "FLIGHT">Flights</option>
                <option value = "EQUIP">Equipment</option>
            </select>
            <br><br>
            
            <input type="submit" name="submit" value="Submit" class="btn btn-success">
            <br>
            <br>
        </form>
        <!--
        What else do we want to search by? PHP up top for session might need to be added/changed

        -->
        <?php 
        include("log_event.php");
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include("../secure/database.php");
        $conn = mysqli_connect(HOST,USERNAME,PASSWORD,DBNAME) or die("Connect Error " . mysqli_error($conn));
        
        $action_date_search = "%{$_POST['action_date']}%";
        $action_type_search = "%{$_POST['action_type']}%";
        $ip_search = "%{$_POST['ip']}%";
             
        $statement = mysqli_prepare($conn, "SELECT * FROM logging WHERE action_date LIKE ? AND action_type LIKE ? AND ip LIKE ?");
        mysqli_stmt_bind_param($statement, "sss", $action_date_search, $action_type_search, $ip_search);
        if(mysqli_stmt_execute($statement)){
            $result = mysqli_stmt_get_result($statement);
            echo "<table class=\"table\">\n";
            echo "<thead>\n\t<tr>\n\t\t<th>Log Number</th>\n\t\t<th>IP</th>\n\t\t<th>Action Date</th>\n\t\t<th>Action Time</th>\n\t\t<th>Action Type</th>\n\t\t<th>Action Description</th>\n\t\t<th>User Employee</th>\n\t\t<th>User Customer</th>\n\t\t<th>Flight Number</th>\n\t</tr>\n</thead>\n";
           
            while ($row = $result->fetch_assoc())
            {
              echo "<tr>\n";
              echo "\t<td>" . $row['log_num'] . "</td>\n";
              echo "\t<td>" . $row['ip'] . "</td>\n";
              echo "\t<td>" . $row['action_date'] . "</td>\n";
              echo "\t<td>" . $row['action_time'] . "</td>\n";
              echo "\t<td>" . $row['action_type'] . "</td>\n"; 
              echo "\t<td>" . $row['action_desc'] . "</td>\n";
              echo "\t<td>" . $row['user_emp'] . "</td>\n";
              echo "\t<td>" . $row['user_cust'] . "</td>\n";   
              echo "\t<td>" . $row['flight_num'] . "</td>\n";      

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
