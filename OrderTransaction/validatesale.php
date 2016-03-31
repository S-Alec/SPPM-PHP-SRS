<?php
	session_start();
	require("../SQL/settings.php");
	require_once("../SQL/QueryDB.php");
	require_once("../SQL/InsertData.php");
	require_once("../SQL/UpdateDB.php");

	if( !isset($_SESSION['loggedin']) )
	{
		exit();
	}

	// Connect to DB
  $mysqli = new mysqli (
   	$host,
   	$user,
   	$pwd,
   	$sql_db
  );

  /* Check Connection */
  if( $mysqli->connect_errno )
  {
  	printf("Connection Failed: %s\n", $mysqli->connect_error);
		exit();	
  }

	if( isset($_POST['json']) )
  {
  	$lErrorMessage = "";
  	$lQuery  = new QueryDB;
  	$lInsert = new InsertData;
  	$lUpdate = new UpdateDB;

  	$lJsonObject = $_POST['json'];
  	$lDecodedObjects = json_decode($lJsonObject);
  	
  	/* Parse Json object into arrays */
  	foreach( $lDecodedObjects as $lDecodedArray)
  	{
  		$lPid[] = $lDecodedArray->{'pid'};
  		$lQuantity[] = $lDecodedArray->{'quantity'};
  	}

  	/* Check for duplicate pids */
  	for( $i = 0; $i < count($lPid); $i++ )
  	{
  		for( $y = 0; $y < count($lPid); $y++ )
  		{
  			if( $i != $y )
  			{
  				if( $lPid[$i] == $lPid[$y] )
  				{
  					// Add Quantity to first $lPid
  					$lQuantity[$i] += $lQuantity[$y];
  					
  					// Remove Pid index and quantity
  					unset($lPid[$y]);
  					unset($lQuantity[$y]);

  					// Reorder arrays
  					$lPid = array_values($lPid);
  					$lQuantity = array_values($lQuantity);
  				}
  			}
  		}
  	}

  	$lTotal = 0;
  	$lValid = 1;

  	/* Validate Transactions */
  	for( $i = 0; $i < count($lPid); $i++ )
  	{
  		$result = $mysqli->query( $lQuery->getProductPriceQuantity($lPid[$i]) );

  		if( !$result )
  		{
  			printf("Query Failed: %s\n", $mysqli->error);
  			exit();
  		}

  		// Check if PID is available (only 1 row)
  		if( $result->num_rows != 1)
  		{
  			$lErrorMessage .= "<li>Product id not found: ".$lPid[$i]."</li>";
  			$lValid = 0;
  		}
  		else
  		{	
  			$row = $result->fetch_assoc();

  			// Check if stock exists
  			if( $row['stockamount'] < $lQuantity[$i] )
  			{
  				$lErrorMessage .= "<li>Insufficient Stock for Pid: ".$lPid[$i]."</li>";

  				$lValid = 0;
  			}
  			else
  			{
  				// Store salesprice
  				$lSalesPrice[] = $row['salesprice'];

  				// Evaluate Total
  				$lTotal += ($lSalesPrice[$i] * $lQuantity[$i]);
  			}
  		}
  	}

  	if( $lValid )
  	{
  		/* Insert receipt into Receipt table */
  		if( $mysqli->query($lInsert->insertReceipt($lTotal)) )
  		{
  			// Get receipt id
  			$lReceiptCode = $mysqli->insert_id;
  		}
  		else
  		{
  			printf("Query Failed: %s\n", $mysqli->error);
  			exit();
  		}

  		for( $i = 0; $i < count($lPid); $i++ )
  		{
	  		/* Insert transaction into transaction table */
	  		if( !$mysqli->query($lInsert->insertTransaction( $lReceiptCode, $lPid[$i], $lSalesPrice[$i], $lQuantity[$i])) )
	  		{
	  			printf("Query Failed: %s\n", $mysqli->error);
  				exit();
	  		}
	  		else
	  		{
	  			/* Update stock amount in sales table */
					if( !$mysqli->query($lUpdate->deductStockFromSalesTable($lPid[$i], $lQuantity[$i])) )
					{
						echo $lUpdate->deductStockFromSalesTable($lPid[$i], $lQuantity[$i]);
						printf("Query Failed: %s\n", $mysqli->error);
  					exit();
					}	
	  		}
	  	}
  	}

  	// Report Errors
  	$mysqli->close();
  	echo $lErrorMessage;
  }
?>