<?php
/**
 *	Handle update User
 */
?>
<?php
	require_once("../SQL/settings.php");
  require_once("model.php");

 if(isset($_POST['pid']))
 {
   $pid = $_POST['pid'];

   $mysqli = new mysqli (
     $host,
     $user,
     $pwd,
     $sql_db
   );

   $productModel = new ProductModel();

   /* Check Connection */
   if( $mysqli->connect_errno )
   {
     printf("Connection Failed: %s\n", $mysqli->connect_error);
     exit();
   }


	 //check if product is used
	 $query = $productModel->checkProductInTransaction($pid);
	 $queryStockOrder = $productModel->checkProductInStockOrder($pid);
	 $result = $mysqli->query($query);
	 $resultStockOrder = $mysqli->query($queryStockOrder);
	 if ($result->num_rows == 0 and $resultStockOrder == 0) {
				$query = $productModel->deleteSaleItem($pid);
				if( $mysqli->query($query) === FALSE )
				{
					printf("Data Handler Failed: %s\n", $mysqli->error);
					$return = 'the product cannot be deleted';
				}
				else {
				 $query = $productModel->deleteProduct($pid);
				 if( $mysqli->query($query) === FALSE )
				 {
					 printf("Data Handler Failed: %s\n", $mysqli->error);
					 $return = 'the product cannot be deleted';
				 }
				 else {
					 $return = 'true';
				 }
				}
	 } else {
		 $return = 'sorry, you can not delete a used stock item';
	 }

   $mysqli->close();

   echo $return;
 }


?>
