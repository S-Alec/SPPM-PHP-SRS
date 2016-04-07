<?php
  /**
   *  Finds all Sale items that match cetain search terms
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
    $result = $mysqli->query( $lQuery->getMatchingProducts($lSearchTerm) );

    if( $result )
    {
	    while( $row = $result->fetch_assoc() )
	    {
	    ?>
	    	<tr id=<?php echo "\"search".$row['pid']."\""; ?>>
	      	<td id=<?php echo "\"bcode".$row['pid']."\""; ?>>
	      	  <?php echo $row['barcode']; ?>
	      	</td>
	      	<td id=<?php echo "\"brand".$row['pid']."\""; ?>>
	      	  <?php echo $row['brand']; ?>
	      	</td>
	      	<td id=<?php echo "\"name".$row['pid']."\""; ?>>
	      	  <?php echo $row['pname']; ?>
	      	</td>
	      	<td id=<?php echo "\"category".$row['pid']."\""; ?>>
	 					<?php echo $row['category']; ?>
	      	</td>
	      	<td id=<?php echo "\"description".$row['pid']."\""; ?>>
	      	  <?php echo $row['description']; ?>
	      	</td>
	      	<td id=<?php echo "\"stock".$row['pid']."\""; ?>>
	      	  <?php echo $row['stockamount']; ?>
	      	</td>
	      	<td id=<?php echo "\"price".$row['pid']."\""; ?>>
	      	  <?php echo round($row['salesprice'], 2); ?>
	      	</td>
	      	<td id=<?php echo "\"action".$row['pid']."\""; ?>>
	      	 	<button type="button" class="btn btn-success" onclick=<?echo "addItemToCart('".$row['pid']."')" ?> >
				  		<span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Add
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