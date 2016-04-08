<?php
/**
 *	Find all transactions belonging to a receipt code
 */
?>
<?php
	session_start();
	require("../SQL/settings.php");
	require_once("../SQL/QueryDB.php");

	/* Check if session is set */
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

	/* Check search terms */
	if( isset($_POST['receiptcode']) )
	{
	 	$lQuery = new QueryDB;
	  $lReceiptCode = $_POST['receiptcode'];

	 	/* Retrieve Items */
	  $result = $mysqli->query( $lQuery->getTransactionDetails($lReceiptCode) );

	  if( $result )
	  {
	  	$lTotal = 0;

		  while( $row = $result->fetch_assoc() )
		  {
		  ?>
		   	<tr>
		   		<td><?php echo $row['barcode']; ?></td>
		   		<td><?php echo $row['brand']; ?></td>
		   		<td><?php echo $row['pname']; ?></td>
		   		<td><?php echo "$".round($row['salesprice'], 2); ?></td>
		   		<td><?php echo $row['quantity']; ?></td>
		   		<td>$<?php echo round( ($row['salesprice'] * $row['quantity']), 2 ); ?></td>
		   	</tr>
		  <?php

		  	$lTotal += ($row['salesprice'] * $row['quantity']);
		  }
		?>
			<tr>
				<td colspan="5">
					<strong>Total : </strong>
				</td>
				<td><strong><?php echo "$".round($lTotal, 2); ?></strong></td>
			</tr>
		<?php
	  }
	  else
		{
		 	printf("Query Failed: %s\n", $mysqli->error); 
		}
	}
	  
	$mysqli->close();
?>