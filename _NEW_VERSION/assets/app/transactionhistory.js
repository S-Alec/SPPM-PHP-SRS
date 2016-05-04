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
  $('#btn-container').html('');
  var lSearchTerm   = $('#searchterm');
  var lSearchButton = $('#search');

  // disable search function
  lSearchButton.prop( "disabled", true );
  lSearchTerm.prop( "disabled", true );

  /* Find the receipt */
  $.ajax({
    method: "POST",
    url   : "/TransactionHistoryController/findReceipt",
    async : true,
    data  : { searchterm: lSearchTerm.val() }
  }).done(function(data) {
    if(data.length > 0)
    {
      var content = '';
      for (var i = 0; i < data.length; i++)
      {

        content += '<tr>'
                        +'<td id="username' + data[i].receiptcode.toString() + '">'
                        +   data[i].username.toString()
                        +'</td>'
                        +'<td id="receiptnumber' + data[i].receiptcode.toString() + '">'
                        +   data[i].receiptcode.toString()
                        +'</td>'
                        +'<td id="date' + data[i].receiptcode.toString() + '">'
                        +   data[i].transactiondate.toString()
                        +'</td>'
                        +'<td id="total' + data[i].receiptcode.toString() + '">'
                        +   parseFloat(data[i].totalspent).toFixed(2).toString()
                        +'</td>'
                        +'<td id="action' + data[i].receiptcode.toString() + '">'
                        +   '<button type="button" class="btn btn-primary" onclick="populateModal('+ data[i].receiptcode.toString() +')">'
                        +      '<span class="glyphicon glyphicon-modal-window" aria-hidden="true"></span> View'
                        +   '</button>'
                        +'</td>'
                      +'</tr>';

      }
      // replace content within the modal transaction table
      var printButton = "<button class='btn btn-primary pull-right' onclick='return printReport(\"" + lSearchTerm.val() + "\",\"\",\"\");'>Print</button>";
      $('#searchresults').html(content);
      $('#btn-container').html(printButton);
    }
    else {
      $('#searchresults').html('');
      $('#btn-container').html('');
    }
    // enable search button
    lSearchButton.prop( "disabled", false );
    lSearchTerm.prop( "disabled", false );
  });

  return false;
}

/**
 *  Validate the date identified by the ID and
 *  visualy display any errors
 *  returns bool
 */
function validateDate(objDate)
{
  var result = false;
  if(objDate.val().trim() != "")
  {
    var aDate = objDate.val().trim().split('/');
    //year, month, day
    var date = new Date(aDate[2], aDate[1], aDate[0]);

    if(date.getDate() != parseInt(aDate[0]) || (date.getMonth() + 1) != parseInt(aDate[1]))
    {
      objDate.removeClass("has-success").addClass("has-error");
      result = false;
    }

    objDate.removeClass("has-error").addClass("has-success");
    result = true;
  }
  else {
    result = false;
  }
  return result;

}

/**
 *  Performs ajax request for all receipts within a
 *  certain range if they are valid.
 */
function findReceiptRange()
{
  $('#btn-container').html('');
  var lDateFrom = $('#datefrom');
  var lDateTo = $('#dateto');

  if(validateDate(lDateFrom) && validateDate(lDateTo))
  {
    /* Get all transaction details */
    $.ajax({
      method: "POST",
      url   : "/TransactionHistoryController/findReceiptRange",
      async : true,
      data  : { datefrom: lDateFrom.val(), dateto: lDateTo.val() }
    }).done(function(data) {
      if(data.length > 0)
      {
        var content = '';
        for (var i = 0; i < data.length; i++)
        {

          content += '<tr>'
                          +'<td id="username' + data[i].receiptcode.toString() + '">'
                          +   data[i].username.toString()
                          +'</td>'
                          +'<td id="receiptnumber' + data[i].receiptcode.toString() + '">'
                          +   data[i].receiptcode.toString()
                          +'</td>'
                          +'<td id="date' + data[i].receiptcode.toString() + '">'
                          +   data[i].transactiondate.toString()
                          +'</td>'
                          +'<td id="total' + data[i].receiptcode.toString() + '">'
                          +   parseFloat(data[i].totalspent).toFixed(2).toString()
                          +'</td>'
                          +'<td id="action' + data[i].receiptcode.toString() + '">'
                          +   '<button type="button" class="btn btn-primary" onclick="populateModal('+ data[i].receiptcode.toString() +')">'
                          +      '<span class="glyphicon glyphicon-modal-window" aria-hidden="true"></span> View'
                          +   '</button>'
                          +'</td>'
                        +'</tr>';

        }
        //alert(content);
        // replace content within the modal transaction table
        var printButton = "<button class='btn btn-primary pull-right' onclick='return printReport(\"\",\"" + lDateFrom.val() + "\", \"" + lDateTo.val() + "\");'>Print</button>";
        $('#searchresults').html(content);
        $('#btn-container').html(printButton);
      }
      else {
        $('#searchresults').html('');
        $('#btn-container').html('');
      }
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
  url   : "/TransactionHistoryController/populateModal",
  async : true,
  data  : { receiptcode: aReceiptCode }
}).done(function( data ) {

  if(data.length > 0)
  {
    var content = '';
    var total = 0;
    for (var i = 0; i < data.length; i++)
    {
      var subTotal = 0
      subTotal = parseFloat(data[i].quantity * data[i].salesprice).toFixed(2).toString();
      total += parseFloat(subTotal);

      content += '<tr>'
        +'<td>'
        +   data[i].barcode.toString()
        +'</td>'
        +'<td>'
        +   data[i].brand.toString()
        +'</td>'
        +'<td>'
        +   data[i].pname.toString()
        +'</td>'
        +'<td>'
        +   parseFloat(data[i].salesprice).toFixed(2).toString()
        +'</td>'
        +'<td>'
        +   data[i].quantity.toString()
        +'</td>'
        +'<td>'
        +   subTotal.toString()
        +'</td>'
        +'</tr>';
    }

    //add total information
    content +='<tr>'
			+'<td colspan="5">'
			+   '<strong>Total : </strong>'
			+'</td>'
      +'<td><strong>' +  parseFloat(total).toFixed(2).toString() + '</strong></td>'
		  +'</tr>';
    // replace content within the modal transaction table
    $('#transactionresults').html(content);

    $('#receiptModal').modal('show');
  }
  else {
    $('#transactionresults').html('');
  }

  return false;

});
}

function printReport(searchterm, datefrom, dateto)
{
   if(searchterm != '')
   {
      window.open('/TransactionHistoryController/printReport?searchterm=' + searchterm, '_blank');
   }
   else {
      window.open('/TransactionHistoryController/printReport?datefrom=' + datefrom + '&dateto=' + dateto, '_blank');
   }
}
