<?php
/**
 *	Find all receipts identified by a user or a receipt code
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
	if( isset($_POST['searchterm']) )
	{
	 	$lQuery = new QueryDB;
	  $lSearchTerm = $_POST['searchterm'];

	 	/* Retrieve Items */
	  $result = $mysqli->query( $lQuery->getMatchingReceipts($lSearchTerm) );

	  if( $result )
	  {
		  while( $row = $result->fetch_assoc() )
		  {
		  ?>
		   	<tr>
		      <td id=<?php echo "\"username".$row['receiptcode']."\""; ?>>
		      	<?php echo $row['username']; ?>
		      </td>
		     	<td id=<?php echo "\"receiptnumber".$row['receiptcode']."\""; ?>>
		      	<?php echo $row['receiptcode']; ?>
		      </td>
		      <td id=<?php echo "\"date".$row['receiptcode']."\""; ?>>
		      	<?php echo $row['transactiondate']; ?>
		      </td>
		      <td id=<?php echo "\"total".$row['receiptcode']."\""; ?>>
		 				<?php echo "$".$row['totalspent']; ?>
		      </td>
		      <td id=<?php echo "\"action".$row['receiptcode']."\""; ?>>
		      	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#receiptModal" onclick=<?echo "populateModal('".$row['receiptcode']."')" ?> >
		      		View 
					  	<span class="glyphicon glyphicon-modal-window" aria-hidden="true"></span>
						</button>
		      </td>
		    </tr>
		  <?php
		  }
	  }
	  else
		{
		 	printf("Query Failed: %s\n", $mysqli->error); 
		}
	}
	  
	$mysqli->close();
?>