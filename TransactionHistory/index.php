<?php
	
	/**
	 *	Datepicker Resources : 
	 *		https://bootstrap-datepicker.readthedocs.org/en/latest/
	 *		
	 *		http://formvalidation.io/examples/jquery-ui-datepicker/#datepicker-programmatic-tab
	 */

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
      <link href="../css/datepicker.css" rel="stylesheet">

      <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
      <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
<<<<<<< HEAD

      <!-- Custom styles for this template -->
      <link href="navbar-static-top.css" rel="stylesheet">
=======
>>>>>>> Fixed-Order-and-History-Transaction-pages
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
<<<<<<< HEAD
            <form action="#searchresults" onsubmit="searchForReceipt()">
=======
            <form onsubmit="return searchForReceipt()">
>>>>>>> Fixed-Order-and-History-Transaction-pages
              <div class="input-group">
                <input id="searchterm" type="text" class="form-control" placeholder="Enter Receipt Code, Username, Lastname, or Role..." required="required">
                <span class="input-group-btn">
                  <button id="search" class="btn btn-default" type="submit">Find</button>
                </span>
              </div>
            </form>
          </div>
          <!-- Date Search -->
          <div class="col-lg-4">
          	<!-- From -->
            <div class="input-group date" data-provide="datepicker">
              <span class="input-group-addon" id="from-addon">From</span>
<<<<<<< HEAD
              <input id="datefrom" type="date" placeholder="DD/MM/YYYY" class="form-control" aria-describedby="from-addon">
=======
              <input id="datefrom" type="text" placeholder="DD/MM/YYYY" class="form-control" aria-describedby="from-addon">
>>>>>>> Fixed-Order-and-History-Transaction-pages
              <!--<span class="input-group-addon glyphicon glyphicon-th" id="calendar-addon-from"></span>-->
            </div>
          </div>
          <div class="col-lg-4">
            <!-- To -->
            <div class="input-group date" data-provide="datepicker">
              <span class="input-group-addon" id="to-addon">To</span>
<<<<<<< HEAD
              <input id="dateto" type="date" placeholder="DD/MM/YYYY" class="form-control" aria-describedby="to-addon">
=======
              <input id="dateto" type="text" placeholder="DD/MM/YYYY" class="form-control" aria-describedby="to-addon">
>>>>>>> Fixed-Order-and-History-Transaction-pages
              <!--<span class="input-group-addon glyphicon glyphicon-th"></span>-->
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

      <!-- Modal -->
      <div class="modal fade" id="receiptModal" tabindex="-1" role="dialog" aria-labelledby="receiptHead">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="receiptHead">Replace with title</h4>
            </div>
            <div class="modal-body">
              <table class="table table-bordered">
              	<tr>
              	  <th><strong>Barcode</strong></th>
              	  <th><strong>Brand</strong></th>
              	  <th><strong>Product</strong></th>
              	  <th><strong>Price</strong></th>
              	  <th><strong>Quantity</strong></th>
              	  <th><strong>Total</strong></th>
              	</tr>
              	<tbody id="transactionresults">
              	  <!-- Replace Content -->
              	</tbody>
             	</table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
      <script src="../js/bootstrap-datepicker.js"></script>
      <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
      <script src="../js/ie10-viewport-bug-workaround.js"></script>
      
      <script>
       	
       	$(document).ready(function() {
       		$.fn.datepicker.defaults.format = "dd/mm/yyyy";

       		$('#datefrom').datepicker()
       		  .on('changeDate', function(){
       		    findReceiptRange();
       		  });

       		$('#dateto').datepicker()
       		  .on('changeDate', function(){
       		    findReceiptRange();
       		  });
       	});
			
       

        /**
         *  Make ajax request to search for receipt
         */
        function searchForReceipt()
        {
          var lSearchTerm   = $('#searchterm');
          var lSearchButton = $('#search');

          // disable search function
          lSearchButton.prop( "disabled", true );
          lSearchTerm.prop( "disabled", true );

          /* Find the receipt */
          $.ajax({
            method: "POST",
            url   : "findreceipt.php",
            async : true,
            data  : { searchterm: lSearchTerm.val() }
          }).done(function( aTableResult ) {

            // replace content within search table
            $('#searchresults').html(aTableResult);
            
            // enable search button
            lSearchButton.prop( "disabled", false );
            lSearchTerm.prop( "disabled", false );
          });
<<<<<<< HEAD
=======

          return false;
>>>>>>> Fixed-Order-and-History-Transaction-pages
        }

        /**
         *  Validate the date identified by the ID and 
         *  visualy display any errors
         *  returns bool
         */
        function validateDate( aDate )
        {
        	if( !Date.parse(aDate.val()) )
        	{
        		aDate.removeClass("has-success").addClass("has-error");
        		return false;
        	}

        	aDate.removeClass("has-error").addClass("has-success");
        	return true;
        }

        /**
         *  Performs ajax request for all receipts within a 
         *  certain range if they are valid. 
         */
        function findReceiptRange()
        {
        	var lDateFrom = $('#datefrom');
        	var lDateTo = $('#dateto');

        	if( validateDate(lDateFrom) && validateDate(lDateTo) )
        	{
        		/* Get all transaction details */
        		$.ajax({
        		  method: "POST",
        		  url   : "findreceiptrange.php",
        		  async : true,
        		  data  : { datefrom: lDateFrom.val(), dateto: lDateTo.val() }
        		}).done(function( aTableResult ) {

        		  // replace content within the search table
        		  $('#searchresults').html(aTableResult);
        		  
        		});
        	}
        }

        /** 
         *	Find and display the data assosciated with a 
         *	receipt code
         */
        function populateModal( aReceiptCode )
        {
        	$('#receiptHead').html("Receipt No. " + aReceiptCode);

        	/* Get all transaction details */
          $.ajax({
            method: "POST",
            url   : "populatemodal.php",
            async : true,
            data  : { receiptcode: aReceiptCode }
          }).done(function( aTableResult ) {

          	// replace content within the modal transaction table
            $('#transactionresults').html(aTableResult);
          
          });
        }

      </script>
    </body>
  </html>
<?php
  } // close session check
?>
