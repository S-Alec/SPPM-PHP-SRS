<?php
  ob_start();
  session_start();
  //check session
  if(!$_SESSION['loggedin']['role'] === "MANAGER" )
  {
    header("location: OrderTransaction/");
  }
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

     </head>

    <body>
      <div class="container">
        <!-- Search Bar -->
        <div class="row">
          <div class="col-lg-6">
            <form onsubmit="return searchForItem()" >
              <div class="input-group">
                <input id="searchterm" type="text" class="form-control" placeholder="Enter Product name, barcode, category, or brand...">
                <span class="input-group-btn">
                  <button id="search" class="btn btn-default" type="submit">Find</button>
                </span>
              </div>
            </form>
          </div>
        </div>

        <hr />

        <!-- Search Results -->
        <div class="panel panel-default">
          <div class="panel-heading">Search Results-</div>
          <table class="table table-bordered">
	        <tr>
	          <th>Barcode</th>
	          <th>Brand</th>
	          <th>Name</th>
	          <th>Category</th>
	          <th>Description</th>
	          <th>Stock</th>
	          <th>Price</th>
	          <th>Action</th>
	        </tr>
	        <tbody id="searchresults">
	          <!-- Replace Content -->
	        </tbody>
	      </table>
        </div>

        <hr />
        <div id="error">
        </div>

        <!-- Order Cart -->
        <div class="panel panel-default">
          <div class="panel-heading">Order Cart-</div>
          <table id="cart" class="table table-bordered">
            <tr>
              <th class="hidden">id</th>
              <th>Barcode</th>
              <th>Brand</th>
              <th>Name</th>
              <th>Category</th>
              <th>Description</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Action</th>
            </tr>
          	<!-- Insert Content -->
          </table>  
          <div class="panel-footer">
            <p id="total" class="pull-right"><strong>Total:</strong> $0.00</p>
            <p></p>
          </div>
        </div>
        
        <hr />
          
        <button id="print" class="btn btn-default pull-right" type="button" onclick="printReceipt()">Print Receipt</button>
      </div> <!-- /container -->

      <?php
        //Assign all Page Specific variables
        $pagemaincontent = ob_get_contents();
        ob_end_clean();
        $pagetitle = 'PHP - Stock Management';
        //Apply the template
        include '../master.php';
      ?>

      <!-- Bootstrap core JavaScript
      ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <script src="../js/bootstrap.min.js"></script>
      <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
      <script src="../js/ie10-viewport-bug-workaround.js"></script>

      <script>
        /**
         *  Query database for search term
         */
        function searchForItem()
        {
          var lSearchTerm   = $('#searchterm');
          var lSearchButton = $('#search');

          // disable search function
          lSearchButton.prop( "disabled", true );
          lSearchTerm.prop( "disabled", true );

          /* Find Item */
          $.ajax({
            method: "POST",
            url   : "findItems.php",
            async : true,
            data  : { searchterm: lSearchTerm.val() }
          }).done(function( aTableResult ) {

            // replace content within search table
            $('#searchresults').html(aTableResult);
            
            // enable search button
            lSearchButton.prop( "disabled", false );
            lSearchTerm.prop( "disabled", false );
          });

          return false;
        }

        /**
         *	Add item to cart
         */
        function addItemToCart( aPid )
        {
          // Determine number of items in table
          var rowCount = $('#cart tr').length;

          var bcode 	   = $('#bcode' + aPid).html();
          var brand 	   = $('#brand' + aPid).html();
          var name  	   = $('#name' + aPid).html();
          var category     = $('#category' + aPid).html();
          var description  = $('#description' + aPid).html();
          var stock 	   = $('#stock' + aPid).html();
          var price 	   = $('#price' + aPid).html();

          rowCount++;

          // Insert row into table
          $('#cart').append('<tr id="row'+rowCount+'">' +
              '<td class="cpid hidden">'+ aPid +'</td>' +
           	  '<td class="cbcode">'+ bcode +'</td>' +
           	  '<td class="cbrand">'+ brand +'</td>' +
           	  '<td class="cname">'+ name + '</td>' + 
           	  '<td class="ccategory">'+ category + '</td>' + 
           	  '<td class="cdesc">'+ description + '</td>' +
           	  '<td class="cprice">'+ price + '</td>' +
           	  '<td><input class="cqty" type="number" min="1" max="'+stock+'" value="1" onchange="calculateTotalCost()"/></td>' +
           	  '<td><button type="button" class="btn btn-danger" onclick="removeItemFromCart('+ rowCount +')">' +
			  	'<span class="glyphicon glyphicon glyphicon-minus" aria-hidden="true"></span> Remove' +
				'</button></td>' +
           	'</tr>'
          );

          // Remove row from Search table
          $('#search' + aPid).remove();

          // Update Total Cost
          calculateTotalCost();
        }

        /**
         *  Remove item from the cart
         */
        function removeItemFromCart( aRow )
        {
          // Remove item from cart
          $('#row'+ aRow).remove();

          // Update total
          calculateTotalCost();
        }

        /**
         *  Calculates the cost of all items in the cart
         *	and updates the total price
         */
        function calculateTotalCost()
        {
          var lTotal = 0;
          var lPrice = 0;
          var lQuantity = 0;

          // Get array of required fields
          var lTablePrices = $("#cart tr td.cprice");
          var lTableQtys = $("#cart tr td input.cqty");

          for( var i = 0; i < lTableQtys.length; i++ )
          {
            lPrice = parseFloat($(lTablePrices[i]).html());
            lQuantity = parseFloat($(lTableQtys[i]).val());

            lTotal += (lPrice * lQuantity);
          }

          // Update Total
          $('#total').html('<strong>Total:</strong> $' + lTotal.toFixed(2));
        }

        /**
         *  Insert transaction into DB and present receipt
         *	to user
         */
        function printReceipt()
        {
         	var lPid;
          var lPostData = [];

          // Disable the Print Receipt button
          $('#print').prop('disabled', true);

          // Get array of required fields
          var lTablePids = $("#cart tr td.cpid");
          var lTableQtys = $("#cart tr td input.cqty");

          for( var i = 0; i < lTablePids.length; i++ )
          {
            lPid = $(lTablePids[i]).html(); 
            lQuantity = parseFloat($(lTableQtys[i]).val());

            if( !Number.isNaN(parseInt(lPid)) )
            {
              lPostData.push( {"pid":lPid, "quantity":lQuantity});
            }
          }
          
          // Validate items can be purchased
          $.ajax({
            method: "POST",
            url   : "validatesale.php",
            async : true,
            data  : { json: JSON.stringify(lPostData) }
          }).done(function( aJSONString ) {

          	var lJson = jQuery.parseJSON(aJSONString);

          	if( !lJson.valid )
          	{
          		// Display Errors
          		$('#error').html("<h3>Errors Detected</h3><ul>"+ lJson.errors +"</ul>");
          		$('#error').addClass("alert alert-danger");
          		
          		// Enable the print button
							$('#print').prop('disabled', false);
          	}
          	else
          	{
          		// Remove Errors
          		$('#error').html("");
          		$('#error').removeClass("alert alert-danger");

          		// Download printed receipt
              window.open('createReceipt.php?receiptcode='+lJson.receiptcode, '_blank');

          		// Reload the page from server
          		document.location.reload(true);
          	}						
          });
        }

      </script>
    </body>
  </html>