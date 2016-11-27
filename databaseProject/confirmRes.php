<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Confirm Reservation</title>

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

    <title>Confirm Reservation</title>

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
          <form class="navbar-form navbar-right">
            <div class="form-group">
              <input type="text" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Sign in</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <br><br><br><br><br><br>
    <div class="container">
        
    <p> Add a reservation? </p>
        <!--  first name, last name, age,
number of bags. The price for the flight will be calculated as the price in the database PLUS $20 for each
bag and 5% sales tax.-->
        <form method="POST" action="confirmation.php" name="resForm">
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
			<option value="1">1</option>
			<option value="2">2</option>
            <option value="3">3</option>	
		</select>
        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
		</form>    
        
     <?php
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include("../secure/database.php");
    $conn = mysqli_connect(HOST,USERNAME,PASSWORD,DBNAME) or die("Connect Error " . mysqli_error($conn));
      
    $yes = $_POST['yes']; 
    $no = $_POST['no']; 

        
    echo "<div class=\"container\"><tr>
        <td>{$fname}</td>
        <td>{$lname}</td>
        <td>{$numBags}</td>
        </tr>";
           
    echo "<p>Would you like to confirm this reservation?</p>
    <form method=\"POST\"><input type=\"submit\" name=\"yes\" value=\"Yes\">
    <input type=\"submit\" name=\"no\" value=\"No\"></form>";
    
    
        
    if (isset($_POST['yes'])) { 
        $ins_statement = mysqli_prepare($conn, "INSERT INTO reservation (fname, lname, price) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($ins_statement, "sss", $fname, $lname, $price);
        $seats_statement = mysqli_prepare($conn, "SELECT flight.price, equipment.seats FROM flight INNER JOIN equipment ON flight.aircraft=equipment.serial WHERE flight.number = ?");
        mysqli_stmt_bind_param($seats_statement, "i", $_POST["flight_no"]);
        
        if(mysqli_stmt_execute($seats_statement)){
          $result = mysqli_stmt_get_result($seats_statement);
          $numRows = mysqli_num_rows($result);
          if($numRows == 1) {
            $row = mysqli_fetch_array($result);
            $numSeats = $row['seats'];
            $price = $row['price'];
          } else {
            echo "Invalid Flight";
            exit();
          }
        }
        
        $numBags = $_POST['bags']; 
        $price += $numBags * 20; //bag price
        $price *= 1.05; //sales tax
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];  

        if(!mysqli_stmt_execute($ins_statement)){
        echo "\nError occurred: " . mysqli_stmt_error($ins_statement);
        }
        mysqli_stmt_close($seats_statement);
        mysqli_stmt_close($ins_statement);
    }
    else header('confirmRes.php');
        
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