<?php
	/** 
	 *	Gets the current stock amount from the Sales table
	 */
?>
<?php
	session_start();
	require("../SQL/settings.php");
	require_once("../SQL/QueryDB.php");

	/* Check if Session is set */
	if( !isset($_SESSION['loggedin']) )
	{
		exit();
	}

	/* Connect to DB */
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

  $lQuery = new QueryDB;
  
  /* Perform Query */
  $result = $mysqli->query( $lQuery->getAllStockQuantity() );

  if( $result )
  {
  	while( $row = $result->fetch_assoc() )
  	{
  		$lLabelType = "label label-default label-pill pull-right ";
  		
  		switch( true )
  		{
  			case $row['stockamount'] <= 10:
  				$lLabelType .= "label-danger";
  				break;
  			case $row['stockamount'] <= 30:
  				$lLabelType .= "label-warning";
  				break;
  			case $row['stockamount'] >= 50:
  				$lLabelType .= "label-success";
  				break;
  			default:
  				$lLabelType .= "label-default";
  		}
  	?>
  		<li class="list-group-item">
  			<span class=<?php echo "\"$lLabelType\""; ?>><?php echo $row['stockamount']; ?></span>
  			<h4 class="list-group-item-heading"><?php echo $row['pname']; ?></h4>
  			<p class="list-group-item-text">
  				<strong>Brand: </strong><?php echo $row['brand']; ?>
  			</p>
  			<p class="list-group-item-text">
  				<strong>Category: </strong><?php echo $row['category']; ?>
  			</p>
  			<p class="list-group-item-text">
  				<strong>Barcode: </strong><?php echo $row['barcode']; ?>
  			</p>
  			<p class="list-group-item-text">
  				<strong>Price: </strong><?php echo $row['salesprice']; ?>
  			</p>
  		</li>
  	<?php
  	}
  }
?>