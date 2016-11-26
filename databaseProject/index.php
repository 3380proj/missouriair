<?php
    
    if (isset($_POST['loginBtn'])){
        
        header("Location: login.php");
        
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
    <link rel="shortcut icon" href="favicon.ico"> 
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
            <button type="submit" name="loginBtn" class="btn btn-success">Employee Login</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>
            <br>
            <div>
            <img src="MissouriAirLogo1.gif" alt="Missouri Air" id="logo">
            </div>
          </h1>
      </div>
    </div>
      

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>Search For Flights</h2>
          <form method="POST" action="list.php" name="flightForm">
            Flight from:
            <input type="text" name="origin" placeholder="City">
            <br>
            Flight to:
            <input type="text" name="dest" placeholder="City">
            <br>
            Departure Date:
            <input type="text" name="departureDate" placeholder="yyyy-mm-dd">
            <br>
            Prices ($0 - $999)
            <input type="text" name="price" placeholder="Enter a price here">
            <button type="submit" name="submit" value="Submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
      </div>

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