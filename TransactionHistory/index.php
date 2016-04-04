<?php
	session_start();

  /* Check Loggedin session */
  if( !isset($_SESSION['loggedin']) || ($_SESSION['loggedin']['role'] != "MANAGER") )
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
      <meta name="description" content="Transaction History Data">

      <title>Transaction History</title>

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
              <li><a href="../Report">Report</a></li>
              <li><a href="../OrderTransaction">Order Transaction</a></li>
              <li><a href="../StockManagement">Stock Management</a>
              <li class="active"><a href="#">Transaction History</a></li>
              <li><a href="../User">User Management</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="../logout.php">Logout</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </nav>


      <div class="container">
        <div class="row">
          <!-- Search Bar -->
          <div class="col-lg-4">
            <form action="#searchresults" onsubmit="searchForReceipt()">
              <div class="input-group">
                <input id="searchterm" type="text" class="form-control" placeholder="Enter Receipt Code...">
                <span class="input-group-btn">
                  <button id="search" class="btn btn-default" type="submit">Find</button>
                </span>
              </div>
            </form>
          </div>
          <!-- Date Search -->
          <div class="col-lg-4">
            <!-- From -->
            <div class="input-group">
              <span class="input-group-addon" id="from-addon">From</span>
              <input id="datefrom" type="date" placeholder="DD/MM/YYYY" onchange="findReceiptRange()" class="form-control" aria-describedby="from-addon">
            </div>
          </div>
          <div class="col-lg-4">
            <!-- To -->
            <div class="input-group">
              <span class="input-group-addon" id="to-addon">To</span>
              <input id="dateto" type="date" placeholder="DD/MM/YYYY" onchange="findReceiptRange()" class="form-control" aria-describedby="to-addon">
            </div>
          </div>
        </div>

        <hr />

        <!-- Search Results -->
        <div class="panel panel-default">
          <div class="panel-heading">Search Results-</div>
          <table class="table table-bordered">
	        <tr>
	          <th>Staff</th>
	          <th>Receipt Number</th>
	          <th>Transaction Date</th>
	          <th>Total Amount</th>
	          <th>Action</th>
	        </tr>
	        <tbody id="searchresults">
	          <!-- Replace Content -->
	        </tbody>
	      </table>
      </div>

      <!-- EXAMPLE -->
      
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
        Launch demo modal
      </button>

      <!-- Modal -->
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
    </div>

      <!-- Bootstrap core JavaScript
      ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <script src="../js/bootstrap.min.js"></script>
      <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
      <script src="../js/ie10-viewport-bug-workaround.js"></script>
      
      <script>
        
        /**
         *  Make ajax request to search for receipt
         */
        function searchForReceipt()
        {
          return false;
        }

        /**
         *  Validate the date identified by the ID and 
         *  visualy display any errors
         *  returns bool
         */
        function validateDate( aDateID )
        {

        }

        /**
         *  Performs ajax request for all receipts within a 
         *  certain range if they are valid. 
         */
        function findReceiptRange()
        {

        }

      </script>
    </body>
  </html>
<?php
  } // close session check
?>
