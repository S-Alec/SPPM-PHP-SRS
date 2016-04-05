<?php
/**
 *	Handle update User
 */
?>
<?php
	require_once("../SQL/settings.php");
  require_once("model.php");

if (isset($_POST['pid']) and isset($_POST['barcode']) and isset($_POST['pname']) and isset($_POST['brand']) and isset($_POST['category']) and isset($_POST['description'])) {
		$pid = $_POST['pid'];
		$barcode = $_POST['barcode'];
		$pname = $_POST['pname'];
		$brand = $_POST['brand'];
		$category = $_POST['category'];
		$description = $_POST['description'];
		$return = false;

   $mysqli = new mysqli (
     $host,
     $user,
     $pwd,
     $sql_db
   );

   $userPro = new ProductModel();

   /* Check Connection */
   if( $mysqli->connect_errno)
   {
     printf("Connection Failed: %s\n", $mysqli->connect_error);
     exit();
   }

	 //check if username exist or not
	 $insert = $userPro->updateProduct($pid,$barcode, $pname, $brand, $category, $description);
	 //echo $insert;
	 if ($mysqli->query($insert) === false) {
			 printf("Data Handler Failed: %s\n", $mysqli->error);
			 $return = 'the product cannot be updated';
	 } else {
			 $return = 'true';
	 }

   $mysqli->close();

   echo $return;
 }


?>
