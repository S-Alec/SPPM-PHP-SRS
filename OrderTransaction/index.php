<?php
  session_start();

  /* Check Loggedin session */
  if( !isset($_SESSION['loggedin']) )
  {
    header("location: ../");
  }
  else
  {
?>
  <!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
      <meta name="description" content="Order Transaction and processing">

      <title>Order Transaction</title>

      <!-- Bootstrap core CSS -->
      <link href="../css/bootstrap.min.css" rel="stylesheet">

      <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
      <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

      <!-- Custom styles for this template -->
      <link href="navbar-static-top.css" rel="stylesheet">
     </head>

    <body>
      <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">SPPM-PHP-SRS</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
             <?php
              /* Manager only Links */
              if( $_SESSION['loggedin']['role'] === "MANAGER" )
              {
              ?>
                <li><a href="../Report">Report</a></li>
              <?php
              }
             ?>
              <li class="active"><a href="#">Order Transaction</a></li>
              <?php
                /* Manager only links */
                if( $_SESSION['loggedin']['role'] === "MANAGER" )
                {
                ?>
                  <li><a href="../StockManagement">Stock Management</a>
                  <li><a href="../TransactionHistory">Transaction History</a></li>
                  <li><a href="../UserManagement">User Management</a></li>
                <?php
                }
              ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="../logout.php">Logout</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </nav>


      <div class="container">
        <!-- Search Bar -->
        <div class="row">
          <div class="col-lg-6">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Enter Product name, barcode, category, or brand...">
              <span class="input-group-btn">
                <button id="search" class="btn btn-default" type="button">Find</button>
              </span>
            </div>
          </div>
        </div>

        <hr />

        <!-- Search Results -->
        <div class="panel panel-default">
          <div class="panel-heading">Search Results-</div>
          <div id="searchresults">
            <table class="table table-bordered">
              <td>
                <th>Barcode</th>
                <th>Brand</th>
                <th>Name</th>
                <th>Category</th>
                <th>Description</th>
                <th>Stock</th>
                <th>Price</th>
                <th>Action</th>
              </td>
            </table>
          </div>
        </div>

        <hr />
        
        <!-- Order Cart -->
        <div class="panel panel-default">
          <div class="panel-heading">Order Cart-</div>
          <table class="table table-bordered">
            <td>
              <th>Barcode</th>
              <th>Brand</th>
              <th>Name</th>
              <th>Category</th>
              <th>Description</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Action</th>
            </td>
          </table>  
        </div>

        <hr />

        <button id="print" class="btn btn-default pull-right" type="button">Print Receipt</button>
      </div> <!-- /container -->


      <!-- Bootstrap core JavaScript
      ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <script src="../js/bootstrap.min.js"></script>
      <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
      <script src="../js/ie10-viewport-bug-workaround.js"></script>
    </body>
  </html>
<?php
  } // close session check
?>
