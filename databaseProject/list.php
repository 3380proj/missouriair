<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Results</title>

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
          <a class="navbar-brand" href="index.html"><img src="MissouriAirLogo2.jpg" style="width:100px;height:100px;"></a>
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

      <h1>Flights Available:</h1>
      
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include("../secure/database.php");
        $conn = mysqli_connect(HOST,USERNAME,PASSWORD,DBNAME) or die("Connect Error " . mysqli_error($conn));
 
        $origin_search = "%{$_POST['origin']}%";
        $dest_search = "%{$_POST['dest']}%";
        $departureDate_search = "%{$_POST['departureDate']}%";
        $price_search = "%{$_POST['price']}%"; 
        $statement = mysqli_prepare($conn, "SELECT * FROM flight WHERE origin LIKE ? AND dest LIKE ? AND day LIKE ? AND price LIKE ?");

        mysqli_stmt_bind_param($statement, "ssss", $origin_search, $dest_search, $departureDate_search, $price_search);

        if(mysqli_stmt_execute($statement)){
            mysqli_stmt_bind_result($statement,$number,$departureDate,$price,$origin,$dest,$dep,$arr,$aircraft,$pilot_1,$pilot_2,$pilot_3,$att_1,$att_2,$att_3);
            echo "<table>\n";
            while (mysqli_stmt_fetch($statement))
            {
              echo "<tr>\n";
              echo "\t<td>" . $origin . "</td>\n";
              echo "\t<td>" . $dest . "</td>\n";
              echo "\t<td>" . $departureDate . "</td>\n";
              echo "\t<td>" . $price . "</td>\n"; 
              echo "\t<td><form><input type=\"submit\" action=\"confirmRes.php\" name=\"resSelect\" value=\"Select Reservation\"></form></td>\n";
              echo "</tr>\n";
            }
            echo "</table>\n";
        }
        mysqli_stmt_close($statement);
        mysqli_close($conn);
      	}
 
 ?>

    </div> <!-- /container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
      
  <?php 
      
      ?>

  </body>
</html>
      
<!-- git pull in folder if outdated locally 
if new submit git add filename
git commit -a 
git push origin master -->
