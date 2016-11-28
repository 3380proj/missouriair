<?php
    $error = false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    
    <title>Reservation Confirmation</title>
    <link rel="shortcut icon" href="favicon.ico"> 
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <script>
        
        function prevCustomer(){
            
            document.getElementById("prev-div").style.display = "block";
            document.getElementById("res-prompt").style.display = "none";
            
        }
        
        function newCustomer(){
            
            document.getElementById("new-div").style.display = "block";
            document.getElementById("res-prompt").style.display = "none";
            
        }
        
    </script>
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
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <br><br><br><br><br><br>
    <div class="container">
        <div id="res-prompt">
            <p>Have you made a reseveration before?</p>
            <input type="submit" name="prevBtn" value="Yes" class="btn btn-primary" onclick="prevCustomer()">
            <input type="submit" name="newBtn" value="No" class="btn btn-primary" onclick="newCustomer()">
        </div>
        
        <div id="new-div" style="display:none;">
            <form method="POST" action="confirmRes.php" name="resForm">
                Flight Number:
                <input type="text" name="flight_no" value="<?php echo $_GET["resSelect"] ?>" readonly>
                <br>
                First Name:
                <input type="text" name="fname" placeholder="First name">
                <br>
                Last Name:
                <input type="text" name="lname" placeholder="Last name">
                <br>
                Number of Bags: 
                <select name="bags">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>	
                </select>
                <input type="submit" name="submit" value="Submit" class="btn btn-primary">
            </form>   
        </div>
        
        <div id="prev-div" style="display:none;">
            <form method="POST" action="confirmRes.php" name="resForm">
                Flight Number:
                <input type="text" name="flight_no" value="<?php echo isset($_GET['resSelect'])?$_GET['resSelect']:null ?>" readonly>
                <br>
                Enter customer ID:
                <input type="text" name="custID" placeholder="Your ID">
                <br>
                Number of Bags: 
                <select name="bags">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>	
                </select>
                <input type="submit" name="submit" value="Submit" class="btn btn-primary">
            </form>   
        </div>
        
     <?php           
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include("../secure/database.php");
        $conn = mysqli_connect(HOST,USERNAME,PASSWORD,DBNAME) or die("Connect Error " . mysqli_error($conn));
    
        $res_statement = mysqli_prepare($conn, "INSERT INTO reservation (flight, customer, price) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($res_statement, "iid", $flight_no, $cust_id, $price);
        $cust_statement = mysqli_prepare($conn, "INSERT INTO customer (fname,lname) VALUES (?, ?)");
        mysqli_stmt_bind_param($cust_statement, "ss", $fname, $lname);
        $seats_statement = mysqli_prepare($conn, "SELECT flight.price, equipment.seats FROM flight INNER JOIN equipment ON flight.aircraft=equipment.serial WHERE flight.number = ?");
        mysqli_stmt_bind_param($seats_statement, "i", $flight_no);
        
        $flight_no = $_POST["flight_no"];

        if(mysqli_stmt_execute($seats_statement)){
          $result = mysqli_stmt_get_result($seats_statement);
          $numRows = mysqli_num_rows($result);
          if($numRows == 1) {
            $row = mysqli_fetch_array($result);
            $numSeats = $row['seats'];
            stmt = mysqli_prepare($conn, "SELECT COUNT(*) as 'count' FROM reservation WHERE flight = ?");
            if ($stmt) {    
                mysqli_stmt_bind_param($stmt, "i", $flight_no);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_array($result);
                seats = $row['count']; 
                if ((numSeats - seats) < 0){
                
                    $error = true;
                    echo '<script type="text/javascript">'; 
                    echo 'window.location.href = "index.php";';
                    echo 'alert("Sorry, this flight has been filled.");'; 
                    echo '</script>';
                    exit();
                }
            } 
            $price = $row['price'];
              
          } else {
            exit();
          }
        }
        
        $numBags = intval($_POST['bags']); 
        $price += $numBags * 20; //bag price
        $price *= 1.05; //sales tax
        if (!isset($_POST['custID'])){
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];  
        }
       

        if (!isset($_POST['custID'])){
            if(mysqli_stmt_execute($cust_statement)){
                echo $fname . " " . $lname;
                $cust_id = mysqli_insert_id($conn); 
            } else {
                echo "\nCustomer creation error occurred: " . mysqli_stmt_error($cust_statement);
            }
        }else{
            
            $custID = $_POST['custID'];
            $stmt = mysqli_prepare($conn, "SELECT id FROM customer WHERE id = ?");
            if ($stmt) {    
                mysqli_stmt_bind_param($stmt, "i", $custID);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $num = mysqli_num_rows($result);
                
                //Row was found (data was valid) = success
                if ($num == 1){
                    
                    $cust_id = $custID;
                    
                }else{
                    $error = true;
                    echo '<script type="text/javascript">'; 
                    echo 'window.location.href = "index.php";';
                    echo 'alert("Invalid customer ID");'; 
                    echo '</script>';
                    exit();
                }
            } 
        }
        if (!$error){
            if(mysqli_stmt_execute($res_statement)){
              $res_num = mysqli_insert_id($conn);
              include("log_event.php");
              log_event($conn, "RESERVE", "Created Reservation {$res_num} on flight {$flight_no}", $flight_no, $cust_id, null);
            } else {
              echo "\nError occurred: " . mysqli_stmt_error($res_statement);
            }
        }
        mysqli_stmt_close($seats_statement);
        mysqli_stmt_close($res_statement);
        mysqli_stmt_close($cust_statement);
        mysqli_close($conn); 
    }
	
?>

    </div> <!-- /container -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>