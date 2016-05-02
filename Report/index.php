<?php

	/**
	 *	Morris Graph -
	 *	http://morrisjs.github.io/morris.js/
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
      <meta name="description" content="Contextual Reports">

      <title>Report</title>

      <!-- Bootstrap core CSS -->
      <link href="../css/bootstrap.min.css" rel="stylesheet">
      <link href="../css/datepicker.css" rel="stylesheet">
      <link href="report.css" rel="stylesheet">
      <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

      <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
      <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
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
              <li class="active"><a href="#">Report</a></li>
              <li><a href="../OrderTransaction">Order Transaction</a></li>
              <li><a href="../Stock">Stock Management</a>
              <li><a href="../TransactionHistory">Transaction History</a></li>
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
          <!-- Date Search -->
          <div class="col-lg-8">
          	<div class="panel panel-default">
          	  <div class="panel-heading">Sales Report</div>
          	  <div class="panel-body">
          	  	<div class="row">
          				<!-- Date From-->
          				<div class="col-lg-6">
          					<div class="input-group date" data-provide="datepicker">
          					  <span class="input-group-addon" id="from-addon">From</span>
          					  <input id="datefrom" type="text" placeholder="DD/MM/YYYY" class="form-control" aria-describedby="from-addon">
          					  <!--<span class="input-group-addon glyphicon glyphicon-th" id="calendar-addon-from"></span>-->
          					</div>
          				</div>
          				<div class="col-lg-6">
          					<!-- Date To -->
          					  <div class="input-group date" data-provide="datepicker">
          					    <span class="input-group-addon" id="to-addon">To</span>
          					    <input id="dateto" type="text" placeholder="DD/MM/YYYY" class="form-control" aria-describedby="to-addon">
          					    <!--<span class="input-group-addon glyphicon glyphicon-th"></span>-->
          					  </div>
          					</div>  		
          	  		</div>
          	  		<hr />
          	  		<!-- Graph -->
          	  		<div class="row">
          	  			<div class="col-lg-12">
          	  				<div id="graph">
          	  				</div>
          	  			</div>
          	  		</div>
          	  	</div>
          	  </div>	
          	</div>
          		<!-- Stock Quantities -->
          		<div class="col-lg-4">
          			<div class="panel panel-default">
          				<div class="panel-heading">Stock Quantity</div>
          				<div id="scroll" class="panel-body">
          					<ul id="stockquantity" class="list-group">
         							<!-- AJAX Request for Stock Quantity -->
          					</ul>
          				</div>
          				<div class="panel-footer">
          					 <button class="btn btn-info btn-group-justified" type="button" onclick="downloadCSVFile()">
          					 		<span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> Create CSV File</button>
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

      <!-- Morris.js Scripts -->
      <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

     <script>
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
        	  url   : "stockQuantity.php",
        	  async : true
        	}).done(function( aResult ) {

        	  // replace content within the search table
        	  $('#stockquantity').html(aResult);
        	  
        	});	
        }

        /**
         *  Open a new tab to download the CSV file
         */
        function downloadCSVFile()
        {
          window.open('downloadCSVFile.php', '_blank');
        }

      </script>

      <!-- Set up the graph -->
      <script>

      	/**
         *  Validate the date identified by the ID and 
         *  visualy display any errors
         *  returns bool
         */
        function validateDate( aDate )
        {
        	if( !Date.parse(aDate) )
        	{
        		return false;
        	}

        	return true;
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
        		  url   : "getStatisticalData.php",
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
        	  url   : "getStatisticalData.php",
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

      </script>
    </body>
  </html>
<?php
	} // Close session check
?>