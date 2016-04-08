<?php
  ob_start();
  session_start();
  //check session
  if(!$_SESSION['loggedin']['role'] === "MANAGER" )
  {
    header("location: OrderTransaction/");
  }
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Order Transaction</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
  <!-- Search Bar -->
  <div class="row">
    <div class="col-lg-6">
      <form action="#searchresults" onsubmit="searchForItem()">
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

<!-- /.row -->
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
  }

  /**
   *	Add item to cart
   */
  function addItemToCart( aPid )
  {
    var bcode 	   = $('#bcode' + aPid).html();
    var brand 	   = $('#brand' + aPid).html();
    var name  	   = $('#name' + aPid).html();
    var category     = $('#category' + aPid).html();
    var description  = $('#description' + aPid).html();
    var stock 	   = $('#stock' + aPid).html();
    var price 	   = $('#price' + aPid).html();

    // Insert row into table
    $('#cart').append('<tr id="'+ aPid +'">' +
        '<td id="cbcode'+ aPid +'">'+ bcode +'</td>' +
        '<td id="cbrand'+ aPid +'">'+ brand +'</td>' +
        '<td id="cname'+ aPid +'">'+ name + '</td>' +
        '<td id="ccategory'+ aPid +'">'+ category + '</td>' +
        '<td id="cdesc'+ aPid +'">'+ description + '</td>' +
        '<td id="cprice'+ aPid +'">'+ price + '</td>' +
        '<td><input id="cqty'+ aPid +'" type="number" min="1" max="'+stock+'" value="1" onchange="calculateTotalCost()"/></td>' +
        '<td><button type="button" class="btn btn-danger" onclick="removeItemFromCart('+ aPid +')">' +
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
  function removeItemFromCart( aPid )
  {
    // Remove item from cart
    $('#'+ aPid).remove();

    // Update total
    calculateTotalCost();
  }

  /**
   *  Calculates the cost of all items in the cart
   *	and updates the total price
   */
  function calculateTotalCost()
  {
    var lPid;
    var lTotal = 0;
    var lPrice = 0;
    var lQuantity = 0;

    // Scan each row of the Cart table
    $('#cart > tbody > tr').each(function(rowIndex) {
      lPid = $(this).attr('id');

      lPrice = parseFloat($('#cprice' + lPid).html());
      lQuantity = parseFloat($('#cqty' + lPid).val());

      if( !Number.isNaN(parseInt(lPid)) )
      {
        lTotal += (lPrice * lQuantity);
      }

    });

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

    // Scan each row of the Cart table
    $('#cart tr').each(function(rowIndex) {

      lPid = $(this).attr('id');
      lQuantity = parseFloat($('#cqty' + lPid).val());

      if( !Number.isNaN(parseInt(lPid)) )
      {
        lPostData.push( {"pid":lPid, "quantity":lQuantity});
      }
    });

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
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
