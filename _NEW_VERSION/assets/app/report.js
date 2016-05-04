
 /* Setup datepicker */
 $(document).ready(function() {
   $.fn.datepicker.defaults.format = "dd/mm/yyyy";

   var lToday = new Date();
   var lTodayString = lToday.getDate() + "/" + (lToday.getMonth()+1) + "/" + lToday.getFullYear();

   $('#datefrom').val(lTodayString);
   $('#dateto').val(lTodayString);

   $('#datefrom').datepicker()
     .on('changeDate', function(){
       getStatisticalData();
     });

   $('#dateto').datepicker()
     .on('changeDate', function(){
       getStatisticalData();
     });

     // Update the current stock quantities list
     getCurrentStockQuantities();

     // Display Graph with todays transactions
     getTodaysStatisticalData();
 });

 /**
  *	Get the current stock quantities for all
  *	sale items
  */
 function getCurrentStockQuantities()
 {
   $.ajax({
     method: "POST",
     url   : "/ReportController/getStockQuantity",
     async : true
   }).done(function(data) {

     $lLabelType = " ";
     if(data.length > 0)
     {
       var content = '';
       var styleClass = '';
       for (var i = 0; i < data.length; i++) {

         styleClass = 'label label-default label-pill pull-right ';

         if(data[i].stockamount <= 10)
         {
           styleClass += 'label-danger';
         }
         else if(data[i].stockamount <= 30)
         {
           styleClass += 'label-warning';
         }
         else if(data[i].stockamount >= 50)
         {
           styleClass += 'label-success';
         }
         else
         {
           styleClass += 'label-default';
         }

         content += '<li class="list-group-item">'
                     + '<span class="' + styleClass + '">' + data[i].stockamount.toString() + '</span>'
                     + '<h4 class="list-group-item-heading">' + data[i].pname.toString() + '</h4>'
                     + '<p class="list-group-item-text">'
                     + '<strong>Brand: </strong>' + data[i].brand.toString()
                     + '</p>'
                     + '<p class="list-group-item-text">'
                     + '<strong>Category: </strong>' + data[i].category.toString()
                     + '</p>'
                     + '<p class="list-group-item-text">'
                     + '<strong>Barcode: </strong>' + data[i].barcode.toString()
                     + '</p>'
                     + '<p class="list-group-item-text">'
                     + '<strong>Price: </strong>' + parseFloat(data[i].salesprice).toFixed(2,0).toString()
                     + '</p>'
                   + '</li>';
       }
       // replace content within the search table
       $('#stockquantity').html(content);
     }
     else {
       $('#stockquantity').html('');
     }
   });
 }

 /**
  *  Open a new tab to download the CSV file
  */
 function downloadCSVFile()
 {
   window.open('/ReportController/downloadCSVFile', '_blank');
 }

<!-- Set up the graph -->

 /**
  *  Validate the date identified by the ID and
  *  visualy display any errors
  *  returns bool
  */
 function validateDate( aDate )
 {
   var result = false;
   if(aDate.trim() != "")
   {
     var arrDate = aDate.trim().split('/');
     //year, month, day
     var date = new Date(arrDate[2], arrDate[1], arrDate[0]);

     if(date.getDate() != parseInt(arrDate[0]) || (date.getMonth() + 1) != parseInt(arrDate[1]))
     {
       result = false;
     }

     result = true;
   }
   else {
     result = false;
   }
   return result;
 }




 /**
  *	Get statistical data for the period
  *	Includes: Product name | Amount Sold | Date
  */
 function getStatisticalData()
 {
   var lDateFrom = $('#datefrom');
   var lDateTo = $('#dateto');

   if( validateDate(lDateFrom.val()) && validateDate(lDateTo.val()) )
   {
     $.ajax({
       method: "POST",
       url   : "/ReportController/getStatisticalData",
       async : true,
       data  : { datefrom: lDateFrom.val(), dateto: lDateTo.val() }
     }).done(function( aJSONString ) {

       lDateFrom.prop( "disabled", false );
       lDateTo.prop( "disabled", false );

       updateGraph( aJSONString );
     });

     lDateFrom.prop( "disabled", true );
     lDateTo.prop( "disabled", true );
   }
 }

 /**
  *	Updates the graph with the statistical data
  *	from today
  */
 function getTodaysStatisticalData()
 {
   var lToday = new Date();
   var lTodayString = lToday.getDate() + "/" + (lToday.getMonth()+1) + "/" + lToday.getFullYear();

   $.ajax({
     method: "POST",
     url   : "/ReportController/getStatisticalData",
     async : true,
     data  : { datefrom: lTodayString, dateto: lTodayString }
   }).done(function( aJSONString ) {

     // update graph
     updateGraph(aJSONString);
   });
 }

/**
*	Updates the Graph with the provided data
*	from the Json string
*/
function updateGraph( aJSONString )
{
 var json;
 try
 {
   json = JSON.parse(aJSONString);
 }
 catch(e)
 {
   console.log(e);
   console.log("JSON Check failed");
 }

 // Delete contents within Graph id
 $('#graph').html('');

 if( typeof json == 'object' )
 {
   new Morris.Line({
     // ID of the element in which to draw the chart.
     element: 'graph',
     // Chart data records -- each entry in this array corresponds to a point on
     // the chart.
     data: json.data,
     // The name of the data record attribute that contains x-values.
     xkey: 'date',
     // A list of names of data record attributes that contain y-values.
     ykeys: json.labels,
     // Labels for the ykeys -- will be displayed when you hover over the
     // chart.
     labels: json.labels,

     // resizes graph when viewport size changes
     resize: true
   });
 }
 else
 {
   var lTextFrom = $('#dateto').val();

   new Morris.Line({
     // ID of the element in which to draw the chart.
     element: 'graph',
     // Chart data records -- each entry in this array corresponds to a point on
     // the chart.
     data: [{date: lTextFrom}],
     // The name of the data record attribute that contains x-values.
     xkey: 'date',
     // A list of names of data record attributes that contain y-values.
     ykeys: [0],
     // Labels for the ykeys -- will be displayed when you hover over the
     // chart.
     labels: [0],

     // resizes graph when viewport size changes
     resize: true
   });
 }
}
