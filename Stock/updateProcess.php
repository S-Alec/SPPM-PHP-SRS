<?php
/**
 *	Handle update User
 */
?>
<?php
	require_once("../SQL/settings.php");
  require_once("model.php");

if (isset($_POST['pid']) and isset($_POST['barcode']) and isset($_POST['pname'])
and isset($_POST['brand']) and isset($_POST['category'])
and isset($_POST['description']) and isset($_POST['salesprice'])
and isset($_POST['quantity'])
) {
		$pid = $_POST['pid'];
		$barcode = $_POST['barcode'];
		$pname = $_POST['pname'];
		$brand = $_POST['brand'];
		$category = $_POST['category'];
		$description = $_POST['description'];
		$salesprice = $_POST['salesprice'];
		$quantity = $_POST['quantity'];

		$return = false;

   $mysqli = new mysqli (
     $host,
     $user,
     $pwd,
     $sql_db
   );

   $productModel = new ProductModel();

   /* Check Connection */
   if( $mysqli->connect_errno)
   {
     printf("Connection Failed: %s\n", $mysqli->connect_error);
     exit();
   }

	 //get current stock amount to compare then changes
	  $query = $productModel->getCurrentStockAmount($pid);
	  //echo $query;
		$result = $mysqli->query($query);
		if ($result->num_rows == 1) {
			 //echo "concac"; return;
			 while ($row = $result->fetch_assoc()) {
				 $addStock = $quantity - $row['stockamount'];
			 }
		}

	 //update handle
	 $query = $productModel->updateProduct($pid,$barcode, $pname, $brand, $category, $description);
	 //echo $query;
	 if ($mysqli->query($query) === false) {
			 printf("Data Handler Failed: %s\n", $mysqli->error);
			 $return = 'the product cannot be updated';
	 } else {
			 $query = $productModel->updateSaleItem($pid, $salesprice, $quantity);
			 if ($mysqli->query($query) === false) {
					 printf("Data Handler Failed: %s\n", $mysqli->error);
					 $return = 'the product saleprices and amount cannot be updated';
			 } else {
				 	if($addStock > 0)
					{
						$query = $productModel->insertStockOrder($pid, $addStock);
						if ($mysqli->query($query) === false) {
								printf("Data Handler Failed: %s\n", $mysqli->error);
								$return = 'the product saleprices and amount cannot be updated';
						} else {
							 $return = 'true';
						}
					}
					else {
						$return = 'true';
					}

			 }
	 }

   $mysqli->close();

   echo $return;
 }


?>
