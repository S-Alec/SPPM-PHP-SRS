<?php
  session_start();

  /* redirect page if logged in */
  if( isset($_SESSION['loggedin']) )
  {
    if( $_SESSION['loggedin']['role'] === "STAFF" )
    {
      header("location: OrderTransaction/");
    }

    if( $_SESSION['loggedin']['role'] === "MANAGER" )
    {
      header("location: Report/");
    }
  } 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Login page for manager and staff">
    <!--<link rel="icon" href="../../favicon.ico">-->

    <title>Login</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet">
  </head>

  <body>

    <div class="container">

      <form class="form-signin" role="form" onsubmit="return validateForm()">
        <h2 class="form-signin-heading">Please Login</h2>
        <div id="divusername">
          <label for="username" class="sr-only">Username</label>
          <input type="text" id="username" class="form-control" placeholder="Username" min="2" max="20" pattern="[a-zA-z0-9]+" required autofocus>
        </div>
        <div id="divpassword">
          <label for="password" class="sr-only">Password</label>
          <input type="password" id="password" class="form-control" placeholder="Password" min="8" required>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" onclick="displayErrors()">Login</button>
      </form>

    </div> <!-- /container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

    <script>

      /**
       *  Ensure that user input is valid
       */
      function displayErrors()
      {
        var lUsername = document.getElementById('username');

        /* Validate Username */
        if( lUsername.validity.patternMismatch )
        {
          lUsername.setCustomValidity("Username contains illegal characters");
        }
        else
        {
          lUsername.setCustomValidity("");
        }
      }

      /**
       *  Perform server side validation
       *  AJAX return -
       *    0 : Fail
       *    1 : Staff Login
       *    2 : Manager Login
       */
      function validateForm()
      {
        var lValid = 0;
        var lUsername = $('#username').val();
        var lPassword = $('#password').val();

        $.ajax({
          method: "POST",
          url: "php/validatelogin.php",
          async: false, /* Prevent immediate page redirect */
          data: { username: lUsername, password: lPassword }
        
        }).done(function( valid ) {

          lValid = parseInt(valid);

          if( lValid === 0 )
          {
            /* Display Errors */
            $("#divusername, #divpassword").addClass("has-error");
          }
          else if ( lValid === 1 )
          {
            /* Staff page redirect */
            window.location.href = "OrderTransaction/index.php";
          }
          else if( lValid === 2 )
          {
            /* Manager page redirect */
            window.location.href = "Report/index.php";
          }
        });

        return Boolean(0);
      }
    </script>
  </body>
</html>
