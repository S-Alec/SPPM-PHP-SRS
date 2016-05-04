var CARTCOUNT = 0;
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
    url   : "/OrderTransactionController/find",
    async : true,
    data  : { searchterm: lSearchTerm.val().trim() }
  }).done(function(data) {

    if(data.length > 0)
    {
      var content = '';
      for (var i = 0; i < data.length; i++)
      {
        content += '<tr id="search' + data[i].pid.toString() + '">'
                        +'<td id="bcode' + data[i].pid.toString() + '">'
                        +   data[i].barcode.toString()
                        +'</td>'
                        +'<td id="brand' + data[i].pid.toString() + '">'
                        +   data[i].brand.toString()
                        +'</td>'
                        +'<td id="name' + data[i].pid.toString() + '">'
                        +   data[i].pname.toString()
                        +'</td>'
                        +'<td id="category' + data[i].pid.toString() + '">'
                        +   data[i].category.toString()
                        +'</td>'
                        +'<td id="description' + data[i].pid.toString() + '">'
                        +   data[i].description.toString()
                        +'</td>'
                        +'<td id="stock' + data[i].pid.toString() + '">'
                        +   data[i].stockamount.toString()
                        +'</td>'
                        +'<td id="price' + data[i].pid.toString() + '">'
                        +   parseFloat(data[i].salesprice).toFixed(2).toString()
                        +'</td>'
                        +'<td id="action' + data[i].pid.toString() + '">'
                        +   '<button type="button" class="btn btn-success" onclick="addItemToCart('+ data[i].pid.toString() +')">'
                        +      '<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Add'
                        +   '</button>'
                        +'</td>'
                      +'</tr>';

      }

      // replace content within search table
      $('#searchresults').html(content);

      // enable search button
      lSearchButton.prop( "disabled", false );
      lSearchTerm.prop( "disabled", false );
    }
    else {
        $('#searchresults').html("");
    }
    return false;
  });
}

/**
 *	Add item to cart
 */
function addItemToCart( aPid )
{
  CARTCOUNT++;

  var bcode 	   = $('#bcode' + aPid).html();
  var brand 	   = $('#brand' + aPid).html();
  var name  	   = $('#name' + aPid).html();
  var category     = $('#category' + aPid).html();
  var description  = $('#description' + aPid).html();
  var stock 	   = $('#stock' + aPid).html();
  var price 	   = $('#price' + aPid).html();

  // Insert row into table
  $('#cart').append('<tr id="row'+CARTCOUNT+'">' +
      '<td class="cpid hidden">'+ aPid +'</td>' +
      '<td class="cbcode">'+ bcode +'</td>' +
      '<td class="cbrand">'+ brand +'</td>' +
      '<td class="cname">'+ name + '</td>' +
      '<td class="ccategory">'+ category + '</td>' +
      '<td class="cdesc">'+ description + '</td>' +
      '<td class="cprice">'+ price + '</td>' +
      '<td><input class="cqty" type="number" min="1" max="'+stock+'" value="1" onchange="calculateTotalCost()"/></td>' +
      '<td><button type="button" class="btn btn-danger" onclick="removeItemFromCart('+ CARTCOUNT +')">' +
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
    url   : "/OrderTransactionController/addTransaction",
    async : false,
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
      window.open('/OrderTransactionController/printReceipt?receiptcode='+lJson.receiptcode, '_blank');

      // Reload the page from server
      document.location.reload(true);
    }
  });
}
