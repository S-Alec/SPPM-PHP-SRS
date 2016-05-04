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
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/assets/css/login.css" rel="stylesheet">

    <style>
      #form-signin{
        background: white;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        border-radius: 5px;
      }
    </style>

  </head>

  <body>
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1>SPPM-PHP-SRS</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <hr/>
    <div class="container">

      <form id="form-signin" class="form-signin" role="form" onsubmit="return validateForm()">
        <h4 class="form-signin-heading">Please Login</h4>
        <div id="divusername">
          <label for="username" class="sr-only">Username</label>
          <input type="text" id="username" class="form-control" placeholder="Username" min="2" max="20" pattern="[a-zA-z0-9]+" required autofocus>
        </div>
        </br>
        <div id="divpassword">
          <label for="password" class="sr-only">Password</label>
          <input type="password" id="password" class="form-control" placeholder="Password" min="8" required>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" onclick="displayErrors()">Login</button>
      </form>

    </div> <!-- /container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/assets/js/jquery-2.2.2.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/assets/js/bootstrap.min.js"></script>

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
          url: "/AuthenticationController/login",
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
            window.location.href = "/OrderTransaction/";
          }
          else if( lValid === 2 )
          {
            /* Manager page redirect */
            window.location.href = "/Report/";
          }
        });

        return Boolean(0);
      }
    </script>
  </body>
</html>
